<?php

namespace common\models;

use common\models\query\UserQuery;
use soft\helpers\ArrayHelper;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string $authKey
 * @property bool $type_id [tinyint(3)]
 * @property int $branch_id [int(11)]
 * @property string $firstname [varchar(255)]
 * @property string $lastname [varchar(255)]
 *
 * @property-read mixed $statusName
 * @property-read string $statusBadge
 * @property-read string $fullname
 *
 * @property-read bool $isConsultant
 * @property-read \common\models\Branch $branch
 * @property-read bool $isManager
 * @property-read string $typeName
 *
 * @property string $Host [char(60)]
 * @property string $User [char(32)]
 * @property string $Select_priv [enum('N', 'Y')]
 * @property string $Insert_priv [enum('N', 'Y')]
 * @property string $Update_priv [enum('N', 'Y')]
 * @property string $Delete_priv [enum('N', 'Y')]
 * @property string $Create_priv [enum('N', 'Y')]
 * @property string $Drop_priv [enum('N', 'Y')]
 * @property string $Reload_priv [enum('N', 'Y')]
 * @property string $Shutdown_priv [enum('N', 'Y')]
 * @property string $Process_priv [enum('N', 'Y')]
 * @property string $File_priv [enum('N', 'Y')]
 * @property string $Grant_priv [enum('N', 'Y')]
 * @property string $References_priv [enum('N', 'Y')]
 * @property string $Index_priv [enum('N', 'Y')]
 * @property string $Alter_priv [enum('N', 'Y')]
 * @property string $Show_db_priv [enum('N', 'Y')]
 * @property string $Super_priv [enum('N', 'Y')]
 * @property string $Create_tmp_table_priv [enum('N', 'Y')]
 * @property string $Lock_tables_priv [enum('N', 'Y')]
 * @property string $Execute_priv [enum('N', 'Y')]
 * @property string $Repl_slave_priv [enum('N', 'Y')]
 * @property string $Repl_client_priv [enum('N', 'Y')]
 * @property string $Create_view_priv [enum('N', 'Y')]
 * @property string $Show_view_priv [enum('N', 'Y')]
 * @property string $Create_routine_priv [enum('N', 'Y')]
 * @property string $Alter_routine_priv [enum('N', 'Y')]
 * @property string $Create_user_priv [enum('N', 'Y')]
 * @property string $Event_priv [enum('N', 'Y')]
 * @property string $Trigger_priv [enum('N', 'Y')]
 * @property string $Create_tablespace_priv [enum('N', 'Y')]
 * @property string $ssl_type [enum('', 'ANY', 'X509', 'SPECIFIED')]
 * @property string $ssl_cipher [blob]
 * @property string $x509_issuer [blob]
 * @property string $x509_subject [blob]
 * @property int $max_questions [int(11) unsigned]
 * @property int $max_updates [int(11) unsigned]
 * @property int $max_connections [int(11) unsigned]
 * @property int $max_user_connections [int(11) unsigned]
 * @property string $plugin [char(64)]
 * @property string $authentication_string
 * @property string $password_expired [enum('N', 'Y')]
 * @property int $password_last_changed [timestamp]
 * @property int $password_lifetime [smallint(5) unsigned]
 * @property string $account_locked [enum('N', 'Y')]
 * @property bool $is_deleted [tinyint(1)]
 * @property int $deleted_by [int(11)]
 * @property int $deleted_at [int(11)]
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $fullname;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const TYPE_ADMIN = 1;
    const TYPE_SALE = 2;
    const TYPE_FACTORY = 3;

    /**
     * Admin tomonidan filiallar uchun xodim (menejer va konsultantlar)
     * qo'shishda kerak bo'ladi
     */
    const SCENARIO_CREATE_BY_ADMIN = 'create_by_admin';

    /**
     * Admin tomonidan filiallardagi xodim (menejer va konsultantlar)ni
     * tahrirlashda kerak bo'ladi
     */
    const SCENARIO_UPDATE_BY_ADMIN = 'update_by_admin';

    /**
     * Menejer tomonidan o'zining filialiga konsultantlar
     * qo'shishda kerak bo'ladi
     */
    const SCENARIO_CREATE_BY_MANAGER = 'manager';

    /**
     * Menejer tomonidan o'zining filialidagi konsultantlarni
     * tahrirlashda kerak bo'ladi
     */
    const SCENARIO_UPDATE_BY_MANAGER = 'update_by_admin';

    /**
     * Foy.chilar o'zining shaxsiy ma'lumotlarini tahrirlashda ishlaydi
     */
    const SCENARIO_PERSONAL = 'personal';

    public $password;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    //<editor-fold desc="Parent methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'message' => 'Ushbu login avvalroq band qilingan.'],
            [['username', 'firstname', 'type_id'], 'required'],
            [['username', 'firstname', 'lastname',], 'string', 'max' => 255],
            ['password', 'string', 'min' => 5,],
            ['password', 'trim'],
            ['password', 'required','on' => self::SCENARIO_CREATE],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['type_id', 'integer'],
            ['type_id', 'in', 'range' => array_keys(self::types())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'firstname' => 'Ism',
            'lastname' => 'Familiya',
            'password' => 'Parol',
            'branch_id' => 'Filial nomi',
            'type_id' => 'Xodim turi',
            'typeName' => 'Xodim turi',
            'created_at' => "Yaratildi",
            'updated_at' => "Tahrirlandi",
        ];
    }


    /**
     * @return \common\models\query\UserQuery|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(UserQuery::class, [get_called_class()]);
    }

    //</editor-fold>

    //<editor-fold desc="Required methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'Nofaol',
        ];
    }
    public function getStatusName()
    {
        return ArrayHelper::getArrayValue(self::statuses(), $this->status);
    }
    public function getStatusBadge(): string
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">Faol</span>';
            default:
                return '<span class="badge badge-danger">Nofaol</span>';;
        }
    }
    public function can($permissionName, $params = [])
    {
        return Yii::$app->authManager->checkAccess($this->getId(), $permissionName, $params);
    }

    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    //</editor-fold>

    //<editor-fold desc="Type" defaultstate="collapsed">

    public static function types()
    {
        return [
            self::TYPE_ADMIN => 'Admin',
            self::TYPE_SALE => 'Sotuvchi',
            self::TYPE_FACTORY => 'Ishlab chiqarish',
        ];
    }

    public function getTypeName()
    {
        return ArrayHelper::getArrayValue(self::types(), $this->type_id);
    }


}
