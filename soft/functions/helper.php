<?php    use soft\helpers\Url;    use soft\helpers\ArrayHelper;    /**     * create url     * @param null $url     * @param bool $scheme     * @return string     * @see \yii\helpers\Url::to()     */    function to($url = null, $scheme = false)    {        return Url::to($url, $scheme);    }    /**     * @param $array     * @param $from     * @param $to     * @param null $group     * @return array     * @see \yii\helpers\ArrayHelper::map()     */    function map($array, $from, $to, $group = null)    {        return ArrayHelper::map($array, $from, $to, $group);    }?>