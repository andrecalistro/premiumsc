<?php

namespace Admin\Model\Table;

use Admin\Model\ConfigTrait;
use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Stores Model
 *
 * @method \Admin\Model\Entity\Store get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Store newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Store[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Store|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Store patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Store[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Store findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresTable extends AppTable
{
    use ConfigTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('stores');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('code');

        $validator
            ->allowEmpty('keyword');

        $validator
            ->allowEmpty('value');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    public function getConfig()
    {
        $store = $this->findConfig('store');

        if (!empty($store->logo)) {
            $store->thumb_logo_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->logo, true);
            $store->logo_link = Router::url(DS . "img" . DS . "files" . DS . "Stores" . DS . $store->logo, true);
		} else {
			$store->thumb_logo_link = Router::url(DS . "img" . DS . 'logo_default.png', true);
			$store->logo_link = Router::url(DS . "img" . DS . 'logo_default.png', true);
		}

        if (!empty($store->favicon)) {
            $store->thumb_favicon_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->favicon, true);
            $store->favicon_link = Router::url(DS . "img" . DS . "files" . DS . "Stores" . DS . $store->favicon, true);
		} else {
			$store->thumb_favicon_link = Router::url(DS . "img" . DS . 'favicon_default.png', true);
			$store->favicon_link = Router::url(DS . "img" . DS . 'favicon_default.png', true);
		}

        if (!empty($store->icon)) {
            $store->thumb_icon_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->icon, true);
            $store->icon_link = Router::url(DS . "img" . DS . "files" . DS . "Stores" . DS . $store->icon, true);
        } else {
            $store->thumb_icon_link = Router::url("admin" . DS . "img" . DS . "thumb-default-icon.png", true);
            $store->icon_link = Router::url("admin" . DS . "img" . DS . "default-icon.png", true);
        }

        return $store;
    }

    public function generateApiToken()
    {
        return Security::hash(Time::now('America/Sao_Paulo'), 'sha1', true);
    }
}
