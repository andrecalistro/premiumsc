<?php

namespace Admin\Model;

use Cake\ORM\Query;
use Cake\Utility\Inflector;
use Imagine\Image\Box;

/**
 * Class ConfigTrait
 * @package Admin\Model
 */
trait ConfigTrait
{
    /**
     * @param $data
     * @param $prefix
     * @param bool $hard_delete
     * @return array
     */
    public function prepareSave($data, $prefix, $hard_delete = true)
    {
        $entities = [];
        foreach ($data as $key => $value) {

            $value = $this->upload($value, $prefix);

            !is_array($value) ?: $value = json_encode($value);

            $entities[] = [
                'code' => $prefix,
                'keyword' => $prefix . '_' . $key,
                'value' => $value
            ];
        }

        if ($entities && $hard_delete) {
            $this->hardDeleteAllCondition(['code' => $prefix]);
        }

        return $entities;
    }

    /**
     * @param $prefix
     * @return \stdClass
     */
    public function findConfig($prefix)
    {
        $result = new \stdClass();
        $data = $this->find()
            ->where(['code' => $prefix])
            ->toArray();

        if ($data) {
            foreach ($data as $key => $value) {
                $field = str_replace($prefix . '_', '', $value->keyword);
                $result->$field = $this->isJson($value->value);
            }
        }
        return $result;
    }

    /**
     * @param $code
     * @return \stdClass
     */
    public function findByCode($code)
    {
        $result = new \stdClass();
        $data = $this->find()
            ->where(['code' => $code])
            ->toArray();
        if ($data) {
            foreach ($data as $key => $value) {
                $field = $value->id;
                $result->$field = [
                    'keyword' => $value->keyword,
                    'value' => $this->isJson($value->value)
                ];
            }
            return $result;
        }
        return false;
    }

    /**
     * @param $map
     * @param $result
     * @return mixed
     */
    public function mapFindConfig($map, $result)
    {
        foreach ($map as $key => $value) {
            if (isset($result->$key) && !empty($result->$key)) {
                $map->$key = $this->isJson($result->$key);
            }
        }
        return $map;
    }

    /**
     * @param $keyword
     * @return null
     */
    public function getConfig($keyword)
    {
        $result = $this->find()
            ->where(['keyword' => $keyword])
            ->first();

        return isset($result->value) ? $result->value : null;
    }

    /**
     * @param $keyword
     * @return null
     */
    public function getByKeyword($keyword)
    {
        $result = $this->find()
            ->where(['keyword' => $keyword])
            ->first();

        return isset($result->value) ? $result->value : null;
    }

    /**
     * @param $string
     * @return bool|mixed
     */
    private function isJson($string)
    {
        if (is_string($string) && is_array(json_decode($string, true))) {
            return json_decode($string);
        } else {
            return $string;
        }
    }

    /**
     * @param $value
     * @param $prefix
     * @return null|string
     */
    private function upload($value, $prefix)
    {
        if (is_array($value) && isset($value['error'])) {
            if ($value['error'] > 0) {
                return null;
            }

            $info = pathinfo($value['name']);
            $file = uniqid() . '.' . $info['extension'];
            $path_root = '..' . DS . 'webroot' . DS . 'img' . DS . 'files';
            $path = $path_root . DS . Inflector::camelize(Inflector::pluralize($prefix));
            is_dir($path_root) ?: mkdir($path_root);
            is_dir($path) ?: mkdir($path);
            $image = new \Imagine\Gd\Imagine();

            $image->open($value['tmp_name'])
                ->save($path . DS . $file);

            $image->open($path . DS . $file)
                ->thumbnail(new Box(100, 100))
                ->save($path . DS . 'thumbnail-' . $file);

            $value = $file;
        }
        return $value;
    }
}