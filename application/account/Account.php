<?php
/**
 * User: nathena
 * Date: 2017/6/19 0019
 * Time: 10:38
 */

namespace account;


use zeus\domain\AggregateRoot;

class Account extends AggregateRoot
{
    protected $schema = "t_account";

    /**
     * @param $name
     * @return null|static
     */
    public static function getByUserName($name)
    {
        $spec = new QueryRowSpecification();
        $spec->from("t_account")->where("user_name", trim($name));

        return parent::load($spec);
    }

    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    //验证密码是否正确
    public function check_passwd($passwd)
    {
        $_passwd = md5($passwd . $this->data['user_name']);

        return $_passwd === $passwd;
    }

    //更新数据
    public function update_info(array $data)
    {
        if (empty($data)) {
            return 0;
        }

        unset($data['passwd']);
        $this->setData($data);

        $repo = AccountRepository::getInstance();
        $rowCount = $repo->save($this);

        $this->update_properties();

        return $rowCount;
    }

    public function update_passwd($old_passwd, $new_passwd)
    {

    }

    public function real_update_passwd($new_passwd)
    {

    }
}