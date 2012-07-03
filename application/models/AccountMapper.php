<?php
class Application_Model_AccountMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Account');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Account $account)
    {
        $data = array(
            'a_fname'   => $account->getFname(),
            'a_lname'   => $account->getLname(),
            'a_email'   => $account->getEmail(),
            'a_login'   => $account->getLogin(),
            'a_pass'   => $account->getPassword(),
            'a_regdate' => date('Y-m-d H:i:s')
        );

        if (null === ($id = $account->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Account $account)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $account->setId($row->a_id)
            ->setFname($row->a_fname)
            ->setLname($row->a_lname)
            ->setEmail($row->a_email)
            ->setLogin($row->a_login)
            ->setPassword($row->a_pass)
            ->setRegdate($row->a_regdate);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Account();
            $entry->setId($row->a_id)
                ->setFname($row->a_fname)
                ->setLname($row->a_lname)
                ->setEmail($row->a_email)
                ->setLogin($row->a_login)
                ->setPassword($row->a_pass)
                ->setRegdate($row->a_regdate);
            $entries[] = $entry;
        }
        return $entries;
    }
}