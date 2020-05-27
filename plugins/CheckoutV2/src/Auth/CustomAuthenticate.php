<?php

namespace CheckoutV2\Auth;

use Cake\Auth\FormAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

class CustomAuthenticate extends FormAuthenticate
{
    public function __construct(ComponentRegistry $registry, $config)
    {
        $this->_registry = $registry;

        $this->setConfig([
            'columns' => [],
        ]);

        $this->setConfig($config);
    }

    protected function _findUser($username, $password = null)
    {
        $userModel = $this->_config['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->_config['fields'];
        $conditions = [$model . '.' . $fields['username'] => $username];
        in_array('document', $this->_config['columns']) ?: array_push($this->_config['columns'], 'document');

        $columns = [];
        foreach ($this->_config['columns'] as $column) {
            $columns[] = [$model . '.' . $column => $username];
        }
        $conditions = ['OR' => $columns];

        if (!empty($this->_config['scope'])) {
            $conditions = array_merge($conditions, $this->_config['scope']);
        }

        $table = TableRegistry::getTableLocator()->get($userModel);

        $result = $table->find('all')
            ->where($conditions)
            ->enableHydration(false);

        if ($this->_config['contain']) {
            $table = $table->contain($this->_config['contain']);
        }
        $result = $result->first();

        if (empty($result)) {
            return false;
        }

        if ($password !== null) {
            $hasher = $this->passwordHasher();
            $hashedPassword = $result[$fields['password']];
            if (!$hasher->check($password, $hashedPassword)) {
                return false;
            }

            $this->_needsPasswordRehash = $hasher->needsRehash($hashedPassword);
            unset($result[$fields['password']]);
        }
        $result['token'] = $table->createToken($result);
        $result['force_update_data'] = $table->verifyRegister($result);
        $result['name_display'] = preg_split('/[\s,]+/', $result['name'], 3);
        return $result;
    }
}