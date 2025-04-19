<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string $full_name
 * @property string $gender
 * @property string $birth_date
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int[] $club_ids
 *
 * @property ClientClub[] $clientClubs
 * @property Club[] $clubs
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 */
class Client extends ActiveRecord
{
    public $club_ids;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'gender', 'birth_date', 'club_ids'], 'required'],
            [['birth_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['club_ids'], 'each', 'rule' => ['integer']],
            [['full_name'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'club_ids' => 'Clubs',
        ];
    }

    /**
     * Gets query for [[ClientClubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientClubs()
    {
        return $this->hasMany(ClientClub::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Clubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClubs()
    {
        return $this->hasMany(Club::class, ['id' => 'club_id'])->viaTable('{{%client_club}}', ['client_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[DeletedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * Gets the IDs of related clubs.
     *
     * @return array
     */
    public function getClubIds()
    {
        return $this->getClubs()->select('id')->column();
    }

    /**
     * Sets the related clubs by their IDs.
     *
     * @param array $ids
     */
    public function setClubIds($ids)
    {
        $this->unlinkAll('clubs', true);
        foreach ($ids as $id) {
            $club = Club::findOne($id);
            if ($club) {
                $this->link('clubs', $club);
            }
        }
    }

    /**
     * Soft deletes the client by setting deleted_at and deleted_by.
     *
     * @return bool Whether the operation was successful.
     */
    public function softDelete()
    {
        $this->deleted_at = new Expression('NOW()');
        $this->deleted_by = Yii::$app->user->id;
        return $this->save(false);
    }
}