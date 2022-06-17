<?phpfunction can($role = ''){    return Yii::$app->user->can($role);}function is_guest(){    return Yii::$app->user->isGuest;}/** * @param null $attribute * @return false|common\models\User|mixed */function user($attribute = null){    $user = Yii::$app->user;    if ($user->isGuest) {        return false;    }    if ($attribute == null) {        /** @return common\models\User */        return $user->identity;    } else {        return $user->identity->{$attribute};    }}function canAdmin(){    return can('admin');}function canSale(){    return can('sale');}function canFinance(){    return can('finance');}function canFactory(){    return can('factory');}function canStore(){    return can('store');}function canSupply(){    return can('supply');}function canCash(){    return can('cash');}/** * Bir nechta rollarni bir vaqtda tekshirish * User kamida bitta rolga ega bo'lsa, true qaytaradi * @param $roles string|array * @return bool */function canRoles($roles){    $roles = (array)$roles;    foreach ($roles as $role) {        if (can($role)) {            return true;        }    }    return false;}