<?php

namespace Admin\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Cake\Validation\Validator;

/**
 * EmailTemplates Model
 *
 * @method \Admin\Model\Entity\EmailTemplate get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\EmailTemplate newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\EmailTemplate[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailTemplate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\EmailTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailTemplate[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailTemplate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailTemplatesTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('email_templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'header' => [
                'path' => 'webroot{DS}img{DS}files{DS}{model}{DS}',
                'nameCallback' => function ($data = null, $settings = null) {
                    $path = pathinfo($data['name']);
                    return uniqid() . '.' . $path['extension'];
                },
                'transformer' => function (RepositoryInterface $table, EntityInterface $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $size = new Box(100, 100);
                    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
            ],
            'footer' => [
                'path' => 'webroot{DS}img{DS}files{DS}{model}{DS}',
                'nameCallback' => function ($data = null, $settings = null) {
                    $path = pathinfo($data['name']);
                    return uniqid() . '.' . $path['extension'];
                },
                'transformer' => function (RepositoryInterface $table, EntityInterface $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $size = new Box(100, 100);
                    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->setProvider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class);

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('subject');

        $validator
            ->allowEmpty('from_name');

        $validator
            ->allowEmpty('from_email');

        $validator
            ->allowEmpty('header');

        $validator
            ->allowEmpty('footer');

        $validator
            ->allowEmpty('tags');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('reply_name');

        $validator
            ->allowEmpty('reply_email');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        $validator
            ->add('header', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 3145728],
                'message' => 'A imagem é grande. O tamanho máximo é de 3MB.',
                'provider' => 'upload'
            ]);

        $validator
            ->add('footer', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 3145728],
                'message' => 'A imagem é grande. O tamanho máximo é de 3MB.',
                'provider' => 'upload'
            ]);

        return $validator;
    }

    /**
     * @param $template
     * @param array $variables
     * @return mixed
     */
    public function buildHtml($template, $variables = [])
    {
        $tags = json_decode($template->tags, TRUE);

        $html =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
				</head>
				<body>
					<table width="600" border="0" align="center" cellspacing="0" cellpadding="0">
						<tr><td><img src="' . $template->header_link . '" style="display:block; margin-bottom: 30px;" alt="" width="600" border="0"></td></tr>
					</table>' .

            $template->content .

            '<table width="600" border="0" align="center" cellspacing="0" cellpadding="0">
						<tr><td><img src="' . $template->footer_link . '" style="display:block; margin-top: 30px;" alt="" width="600" border="0"></td></tr>
					</table>
				</body>
			</html>';

        foreach ($tags as $key => $tag) {
            if (isset($variables[$key])) {
                $variables[$key] = (is_string($variables[$key]) && $variables[$key] == strip_tags($variables[$key]))
                    ? nl2br($variables[$key])
                    : $variables[$key];
            } else {
                $variables[$key] = '';
            }

            $html = str_replace($tags[$key], $variables[$key], $html);
        }

        return $html;
    }
}
