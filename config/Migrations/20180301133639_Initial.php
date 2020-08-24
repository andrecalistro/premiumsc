<?php

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('attributes')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('banners')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('image_width', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image_height', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('background_width', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('background_height', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image_mobile_width', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image_mobile_height', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('background_mobile_width', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('background_mobile_height', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('banners_images')
            ->addColumn('banners_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('target', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('background', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('background_mobile', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image_mobile', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('start_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('always', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('sunday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('monday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('tuesday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('wednesday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('thursday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('friday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('saturday', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('subtitle', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('link_text', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('bling_customers')
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bling_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('bling_orders')
            ->addColumn('orders_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bling_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('bling_order', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('bling_products')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bling_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('bling_providers')
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bling_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('carts')
            ->addColumn('session_id', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('option', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('unit_price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('total_price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('categories')
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_total', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('abbreviation', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('order_show', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('show_launch_menu', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('categories_visitors')
            ->addColumn('categories_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('customers')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('document', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('document_clean', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('last_visit', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_buy', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('telephone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('cellphone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('birth_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('customers_addresses')
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('zipcode', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('complement', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('neighborhood', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('customers_confirmations')
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('customers_resets')
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('email_logs')
            ->addColumn('email_queues_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email_statuses_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('sent_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('email_queues')
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('from_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('from_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('reply_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('reply_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('to_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('to_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email_statuses_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('send_status', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('email_statuses')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('email_templates')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('from_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('from_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('who_receives', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('header', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('footer', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('emails_marketings')
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('faq_categories')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('pages', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('faq_questions')
            ->addColumn('faq_categories_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('question', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('answer', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('position', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('filters')
            ->addColumn('filters_groups_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('filters_groups')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('lendings')
            ->addColumn('customer_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('customer_email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('send_status', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('send_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('users_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('lendings_products')
            ->addColumn('status', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('lendings_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('menus')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('icon', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('plugin', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('controller', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('action', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('params', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('position', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders')
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('customers_addresses_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('orders_statuses_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('zipcode', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('complement', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('neighborhood', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('subtotal', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('shipping_total', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('total', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('total_without_discount', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('discount', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('discount_percent', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('payment_method', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('payment_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('payment_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('payment_document', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('payment_birth_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('payment_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('payment_installment', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('payment_installment_value', 'decimal', [
                'default' => '0.00',
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('payment_brand', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('payment_card_number', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('shipping_code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('shipping_text', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('shipping_deadline', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('shipping_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('tracking', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('orders_types_id', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders_histories')
            ->addColumn('orders_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('orders_statuses_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('notify_customer', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('comment', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders_products')
            ->addColumn('orders_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('products_options_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image_thumb', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('price_special', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('price_total', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders_statuses')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('orders_types')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('pages')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('seo_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('payments')
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('keyword', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('payments_methods')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('positions')
            ->addColumn('positions_pages_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('positions_pages')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products')
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('ean', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('stock', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('price_special', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('price_promotional', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 20,
                'scale' => 2,
            ])
            ->addColumn('stock_control', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('show_price', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('weight', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 3,
            ])
            ->addColumn('length', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 3,
            ])
            ->addColumn('width', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 3,
            ])
            ->addColumn('height', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 3,
            ])
            ->addColumn('shipping_free', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('seo_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('seo_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('main', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('positions_id', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image_background', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('condition_product', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('launch_product', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('video', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('resume', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('providers_payment_status', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('products_conditions_id', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_attributes')
            ->addColumn('attributes_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_categories')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('categories_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_conditions')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_filters')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('filters_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_images')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('main', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_positions')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('positions_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('order_show', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_relateds')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('childs_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_sales')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('count', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_searches')
            ->addColumn('term', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_statuses')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('purchase', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('view', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_tabs')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('order_show', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products_variations')
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('variations_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('variations_groups_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('required', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('stock', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('providers')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('telephone', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bank', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('agency', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('account', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('document', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('commission', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('zipcode', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 105,
                'null' => true,
            ])
            ->addColumn('complement', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('neighborhood', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('rules')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('public', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('rules_menus')
            ->addColumn('rules_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('menus_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('shipments')
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('keyword', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('stocks_statuses')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('stores')
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('keyword', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('testimonials')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('company', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('avatar', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('rules_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('variations')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('variations_groups_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('variations_groups')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();











        /*
         * Inserindo os registros iniciais padrão
         */
        $date = date('Y-m-d H:i:s');

		$this->table('email_statuses')
			->insert([
				[
					'name' => 'Pendente',
					'slug' => 'pendente',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Enviado',
					'slug' => 'enviado',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Erro',
					'slug' => 'erro',
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('email_templates')
			->insert([
				[
					'name' => 'Contato',
					'slug' => 'contato',
					'subject' => 'Contato',
					'from_name' => 'Contato Loja',
					'from_email' => 'contato@nerdweb.com.br',
					'who_receives' => NULL,
					'header' => '',
					'footer' => '',
					'tags' => '{"name": "[NOME]","email": "[EMAIL]","telephone": "[TELEFONE]","subject": "[ASSUNTO]","message": "[MENSAGEM]"}',
					'content' =>
						'<table style="font-family: \'Arial\', sans-serif; margin-bottom: 100px; font-size: 15px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody>
								<tr>
									<td>
										<p style="font-size: 18px; font-weight: 700; margin: 0 0 10px;">Olá,</p>
										<p style="margin: 0 0 20px;">Recebemos um contato pela loja, aqui estão as informações enviadas pelo cliente:</p>
									</td>
								</tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p style="font-weight: 700;">INFORMAÇÕES ENVIADAS PELO CLIENTE</p>
									</td>
								</tr>
								<tr>
									<td style="padding: 1px;"></td>
								</tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p><strong>Nome:</strong> [NOME]</p>
										<p><strong>E-mail:</strong> [EMAIL]</p>
										<p><strong>Celular:</strong> [TELEFONE]</p>
										<p><strong>Assunto:</strong> [ASSUNTO]</p>
										<p>
											<strong>Mensagem:</strong><br><br>
											[MENSAGEM]
										</p>
									</td>
								</tr>
							</tbody>
						</table>',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Novo Pedido',
					'slug' => 'novo-pedido',
					'subject' => 'Novo Pedido Realizado',
					'from_name' => 'Contato Loja',
					'from_email' => 'contato@nerdweb.com.br',
					'who_receives' => NULL,
					'header' => '',
					'footer' => '',
					'tags' => '{"orders_id": "[ID_PEDIDO]","name": "[NOME]","document": "[CPF]","email": "[EMAIL]","telephone": "[TELEFONE]","address": "[ENDERECO]","zipcode": "[CEP]","city": "[CIDADE]","uf": "[ESTADO]","products": "[PRODUTOS]","subtotal": "[VALOR_SUBTOTAL]","shipping_text": "[TIPO_FRETE]","shipping_total": "[VALOR_FRETE]","discount": "[VALOR_DESCONTO]","total": "[VALOR_TOTAL]","payment_type": "[FORMA_PAGAMENTO]","payment_condition": "[CONDICAO_PAGAMENTO]","shipping_deadline": "[PRAZO_ENTREGA]","order_url": "[URL_PEDIDO]"}',
					'content' =>
						'<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody>
								<tr>
									<td>
										<p style="font-size: 18px; font-weight: 700; margin: 0 0 10px;">Olá,</p>
										<p style="margin: 0 0 20px;">Recebemos um novo pedido: lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed feugiat eros. Sed at nunc a orci laoreet gravida.</p>
									</td>
								</tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p style="font-weight: 700; text-align: center;">PEDIDO NUMERO #[ID_PEDIDO]</p>
									</td>
								</tr>
								<tr><td style="padding: 1px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p><strong>DADOS DO CLIENTE</strong></p>
										<p><strong>Nome:</strong> [NOME]</p>
										<p><strong>CPF:</strong> [CPF]</p>
										<p><strong>E-mail:</strong> [EMAIL]</p>
										<p><strong>Telefone:</strong> [TELEFONE]</p>
										<p><strong>Endereço:</strong> [ENDERECO]</p>
										<p><strong>CEP:</strong> [CEP]</p>
										<p><strong>Cidade/UF:</strong> [CIDADE]/[ESTADO]</p>
									</td>
								</tr>
								<tr><td style="padding: 10px;"></td></tr>
								<tr>
									<td>
										[PRODUTOS]
				
										<table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
											<tbody>
												<tr style="font-weight: 700;font-size: 16px;">
													<td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
														<p>SUBTOTAL:</p>
													</td>
													<td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
														<p>[VALOR_SUBTOTAL]</p>
													</td>
												</tr>
												<tr><td style="padding: 1px;"></td></tr>
												<tr style="font-weight: 700;font-size: 16px;">
													<td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
														<p>FRETE <span style="font-weight: 400; font-size: 14px;">([TIPO_FRETE])</span>:</p>
													</td>
													<td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
														<p>[VALOR_FRETE]</p>
													</td>
												</tr>
												<tr><td style="padding: 1px;"></td></tr>
												<tr style="font-weight: 700;font-size: 16px;">
													<td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
														<p>DESCONTO:</p>
													</td>
													<td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
														<p>- [VALOR_DESCONTO]</p>
													</td>
												</tr>
												<tr><td style="padding: 1px;"></td></tr>
												<tr style="font-weight: 700;font-size: 16px;">
													<td style="background-color: #e3e3e3; padding: 15px;" colspan="4">
														<p>TOTAL:</p>
													</td>
													<td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
														<p>[VALOR_TOTAL]</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr><td style="padding: 10px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p style="font-weight: 700;">FORMA DE PAGAMENTO</p>
									</td>
								</tr>
								<tr><td style="padding: 1px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p><strong>[FORMA_PAGAMENTO]</strong></p>
										<p>[CONDICAO_PAGAMENTO]</p>
									</td>
								</tr>
								<tr><td style="padding: 10px;"></td></tr>
								<tr>
									<td>
										<table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
											<tbody>
												<tr style="font-weight: 700;font-size: 16px;">
													<td style="background-color: #f4f4f4; padding: 15px;">
														<p>PRAZO DE ENTREGA</p>
													</td>
													<td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
														<p>[PRAZO_ENTREGA]</p>
													</td>
												</tr>
												<tr><td style="padding: 1px;"></td></tr>
												<tr>
													<td style="background-color: #f4f4f4; padding: 20px;" colspan="3">
														<p style="font-size: 14px;">O prazo é sempre informado em dias úteis e começa a ser contado a partir da data de confirmação do pagamento.</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr><td style="padding: 10px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 20px; text-align: center;">
										<a target="_blank" href="[URL_PEDIDO]">Clique aqui e acompanhe o seu pedido.</a>
									</td>
								</tr>
								<tr>
									<td>
										<p style="padding: 30px 0 0;">Texto complementar:</p>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
									</td>
								</tr>
							</tbody>
						</table>',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Alteração de Status',
					'slug' => 'alteracao-de-status',
					'subject' => 'Alteração de Status do Pedido',
					'from_name' => 'Contato Loja',
					'from_email' => 'contato@nerdweb.com.br',
					'who_receives' => NULL,
					'header' => '',
					'footer' => '',
					'tags' => '{"orders_id": "[ID_PEDIDO]","status": "[STATUS]","order_url": "[URL_PEDIDO]"}',
					'content' =>
						'<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody>
								<tr>
									<td>
										<p style="font-size: 18px; font-weight: 700; margin: 0 0 10px;">Olá,</p>
										<p style="margin: 0 0 20px;">O status do seu pedido foi alterado, seguem as informações:</p>
									</td>
								</tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p style="font-weight: 700; text-align: center;">PEDIDO NUMERO #[ID_PEDIDO]</p>
									</td>
								</tr>
								<tr><td style="padding: 1px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 15px;">
										<p><strong>[STATUS]</strong></p>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.</p>
									</td>
								</tr>
								<tr><td style="padding: 1px;"></td></tr>
								<tr>
									<td style="background-color: #f4f4f4; padding: 20px; text-align: center;">
										<a target="_blank" href="[URL_PEDIDO]">Clique aqui e acompanhe o seu pedido.</a>
									</td>
								</tr>
								<tr>
									<td>
										<p style="padding: 30px 0 0;">Texto complementar:</p>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
									</td>
								</tr>
							</tbody>
						</table>',
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

        $this->table('orders_statuses')
			->insert([
				[
					'name' => 'Aguardando Pagamento',
					'slug' => 'aguardando-pagamento',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Pagamento Aprovado',
					'slug' => 'pagamento-aprovado',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Preparando para Envio',
					'slug' => 'preparando-para-envio',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Pedido Enviado',
					'slug' => 'pedido-enviado',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Entrega Realizada',
					'slug' => 'entrega-realizada',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Cancelado',
					'slug' => 'cancelado',
					'created' => $date,
					'modified' => $date
				],
			])
			->save();

		$this->table('orders_types')
			->insert([
				[
					'name' => 'Online',
					'slug' => 'online',
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Offline',
					'slug' => 'offline',
					'created' => $date,
					'modified' => $date
				],
			])
			->save();

		$this->table('payments_methods')
			->insert([
				[
					'name' => 'Cartão de Crédito',
					'slug' => 'credit-card',
					'image' => null,
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Cartão de Débito',
					'slug' => 'debit-card',
					'image' => null,
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Boleto',
					'slug' => 'ticket',
					'image' => null,
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('products_statuses')
			->insert([
				[
					'name' => 'Habilitado',
					'slug' => 'habilitado',
					'purchase' => 1,
					'view' => 1,
					'created' => $date,
					'modified' => $date
				],
				[
					'name' => 'Desabilitado',
					'slug' => 'desabilitado',
					'purchase' => 0,
					'view' => 1,
					'created' => $date,
					'modified' => $date
				],
			])
			->save();

		$this->table('menus')
			->insert([
				['name' => 'Dashboard', 'icon' => 'fa-bar-chart', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => 'stores', 'action' => 'dashboard', 'params' => '', 'status' => 1, 'position' => 1, 'created' => $date, 'modified' => $date],
				['name' => 'Produtos', 'icon' => '', 'parent_id' => 17, 'plugin' => 'admin', 'controller' => 'products', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 1, 'created' => $date, 'modified' => $date],
				['name' => 'Minhas Vendas', 'icon' => 'fa-usd', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => 'orders', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 3, 'created' => $date, 'modified' => $date],
				['name' => 'Meus Clientes', 'icon' => '', 'parent_id' => 27, 'plugin' => 'admin', 'controller' => 'customers', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 1, 'created' => $date, 'modified' => $date],
				['name' => 'Vitrine', 'icon' => 'fa-thumb-tack', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => 'positions', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 2, 'created' => $date, 'modified' => $date],
				['name' => 'Marketing', 'icon' => 'fa-bullhorn', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 1, 'position' => 6, 'created' => $date, 'modified' => $date],
				['name' => 'Assinaturas', 'icon' => 'fa-repeat', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 0, 'position' => 7, 'created' => $date, 'modified' => $date],
				['name' => 'Ativas', 'icon' => '', 'parent_id' => 7, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 0, 'position' => 1, 'created' => $date, 'modified' => $date],
				['name' => 'Assinates', 'icon' => '', 'parent_id' => 7, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 0, 'position' => 2, 'created' => $date, 'modified' => $date],
				['name' => 'Configurações', 'icon' => 'fa-cog', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 1, 'position' => 7, 'created' => $date, 'modified' => $date],
				['name' => 'Loja', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'stores', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 1, 'created' => $date, 'modified' => $date],
				['name' => 'Frete', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'shipments', 'action' => 'index', 'params' => NULL, 'status' => 1, 'position' => 2, 'created' => $date, 'modified' => $date],
				['name' => 'Gateways de Pagamentos', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'payments', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 3, 'created' => $date, 'modified' => $date],
				['name' => 'Status de Pedido', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'orders-statuses', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 4, 'created' => $date, 'modified' => $date],
				['name' => 'Status de Estoque', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'stocks-statuses', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 5, 'created' => $date, 'modified' => $date],
				['name' => 'Formas de Pagamento', 'icon' => '', 'parent_id' => 26, 'plugin' => 'admin', 'controller' => 'payments_methods', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 6, 'created' => $date, 'modified' => $date],
				['name' => 'Catálogo', 'icon' => 'fa-archive', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 1, 'position' => 4, 'created' => $date, 'modified' => $date],
				['name' => 'Filtros', 'icon' => '', 'parent_id' => 17, 'plugin' => 'admin', 'controller' => 'filters-groups', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 2, 'created' => $date, 'modified' => $date],
				['name' => 'Categorias', 'icon' => '', 'parent_id' => 17, 'plugin' => 'admin', 'controller' => 'categories', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 3, 'created' => $date, 'modified' => $date],
				['name' => 'Usuários', 'icon' => '', 'parent_id' => 10, 'plugin' => 'admin', 'controller' => 'users', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 7, 'created' => $date, 'modified' => $date],
				['name' => 'Banners', 'icon' => '', 'parent_id' => 26, 'plugin' => 'admin', 'controller' => 'banners', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 8, 'created' => $date, 'modified' => $date],
				['name' => 'Email Marketing', 'icon' => '', 'parent_id' => 6, 'plugin' => 'admin', 'controller' => 'emails-marketings', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 2, 'created' => $date, 'modified' => $date],
				['name' => 'Depoimentos', 'icon' => '', 'parent_id' => 26, 'plugin' => 'admin', 'controller' => 'testimonials', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 9, 'created' => $date, 'modified' => $date],
				['name' => 'Páginas estáticas', 'icon' => '', 'parent_id' => 26, 'plugin' => 'admin', 'controller' => 'pages', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 10, 'created' => $date, 'modified' => $date],
				['name' => 'Atributos', 'icon' => '', 'parent_id' => 17, 'plugin' => 'admin', 'controller' => 'attributes', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 11, 'created' => $date, 'modified' => $date],
				['name' => 'CMS', 'icon' => 'fa-file-code-o', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 1, 'position' => 6, 'created' => $date, 'modified' => $date],
				['name' => 'CRM', 'icon' => 'fa-address-card', 'parent_id' => 0, 'plugin' => 'admin', 'controller' => '#', 'action' => '', 'params' => '', 'status' => 1, 'position' => 5, 'created' => $date, 'modified' => $date],
				['name' => 'Templates de e-mail', 'icon' => '', 'parent_id' => 26, 'plugin' => 'admin', 'controller' => 'email-templates', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 12, 'created' => $date, 'modified' => $date],
				['name' => 'Menus', 'icon' => 'fa-bars', 'parent_id' => NULL, 'plugin' => 'admin', 'controller' => 'menus', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 8, 'created' => $date, 'modified' => $date],
				['name' => 'Grupos', 'icon' => 'fa-users', 'parent_id' => NULL, 'plugin' => 'admin', 'controller' => 'rules', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 9, 'created' => $date, 'modified' => $date],
				['name' => 'Atualizar Produtos em massa', 'icon' => '', 'parent_id' => 17, 'plugin' => 'admin', 'controller' => 'products', 'action' => 'update', 'params' => '', 'status' => 1, 'position' => 5, 'created' => $date, 'modified' => $date],
                ['name' => 'Google Shopping', 'icon' => '', 'parent_id' => 6, 'plugin' => 'integrators', 'controller' => 'google-shopping', 'action' => 'index', 'params' => '', 'status' => 1, 'position' => 2, 'created' => $date, 'modified' => $date]
			])
			->save();

        $this->table('rules')
			->insert([
				[
					'name' => 'Administrador',
					'public' => 1,
					'created' => $date,
                	'modified' => $date
				],
				[
					'name' => 'Superadministrador',
					'public' => 0,
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('rules_menus')
			->insert([
				['rules_id' => 1, 'menus_id' => 1, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 2, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 3, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 4, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 5, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 6, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 7, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 8, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 9, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 10, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 11, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 12, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 13, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 14, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 15, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 16, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 17, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 18, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 19, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 20, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 21, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 22, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 23, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 24, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 25, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 26, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 27, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 28, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 29, 'created' => $date, 'modified' => $date],
				['rules_id' => 1, 'menus_id' => 31, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 1, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 2, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 3, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 4, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 5, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 6, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 7, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 8, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 9, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 10, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 11, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 12, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 13, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 14, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 15, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 16, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 17, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 18, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 19, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 20, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 21, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 22, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 23, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 24, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 25, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 26, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 27, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 28, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 29, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 30, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => 31, 'created' => $date, 'modified' => $date],
                ['rules_id' => 1, 'menus_id' => 32, 'created' => $date, 'modified' => $date],
                ['rules_id' => 2, 'menus_id' => 32, 'created' => $date, 'modified' => $date],
			])
			->save();

        $this->table('users')
			->insert([
				[
					'name' => 'Admin',
					'email' => 'andrecalistro@hotmail.com',
					'password' => (new DefaultPasswordHasher)->hash('#premiumsc2020'),
					'rules_id' => 2,
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('pages')
			->insert([
				[
					'name' => 'Termos e Condições',
					'slug' => 'termos-e-condicoes',
					'status' => 1,
					'content' => '<p>Termos e Condições</p>',
					'created' => $date,
					'modified' => $date,
				]
			])
			->save();

		$this->table('stores')
			->insert([
				[
					'code' => 'main',
					'keyword' => 'main_api_token',
					'value' => Security::hash(Time::now('America/Sao_Paulo'), 'sha1', true),
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'main',
					'keyword' => 'main_template_product_form',
					'value' => 'default',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_api_key',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_status',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_synchronize_providers',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_synchronize_customers',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_synchronize_products',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_synchronize_orders',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'bling',
					'keyword' => 'bling_synchronize_orders_statuses_id',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_name',
					'value' => 'Loja Premium Shirts Club',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_document',
					'value' => '99.999.999/9999-99',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_telephone',
					'value' => '(41) 3333-3333',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_cellphone',
					'value' => '(41) 99999-9999',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_terms_pages_id',
					'value' => 1,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_logo',
					'value' => NULL,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_favicon',
					'value' => NULL,
					'created' => $date,
					'modified' => $date],
				[
					'code' => 'store',
					'keyword' => 'store_icon',
					'value' => NULL,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_zipcode',
					'value' => '80620-010',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_address',
					'value' => 'Avenida República Argentina',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_number',
					'value' => '1228',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_complement',
					'value' => 'sala 1806',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_neighborhood',
					'value' => 'Vila Izabel',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_city',
					'value' => 'Curitiba',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_state',
					'value' => 'PR',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_email_notification',
					'value' => 'formulario.contato@nerdweb.com.br',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_email_contact',
					'value' => 'formulario.contato@nerdweb.com.br',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_status_new_order',
					'value' => 1,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_status_completed_order',
					'value' => 4,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_seo_title',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_seo_description',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_facebook',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_instagram',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_twitter',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_blog_url',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_analytics_account_id',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_analytics_property_id',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_google_analytics_ecommerce_status',
					'value' => 0,
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_google_analytics',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_google_recaptcha_site_key',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_google_recaptcha_secret_key',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_facebook_pixel',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_additional_scripts_header',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_additional_scripts_footer',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'store',
					'keyword' => 'store_orders_statuses_config',
					'value' => '{"1":{"products_statuses_id":"1","control_stock":"down"},"2":{"products_statuses_id":"1","control_stock":"neutral"},"3":{"products_statuses_id":"1","control_stock":"neutral"},"4":{"products_statuses_id":"1","control_stock":"neutral"},"5":{"products_statuses_id":"1","control_stock":"neutral"},"6":{"products_statuses_id":"1","control_stock":"up"}}',
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('payments')
			->insert([
				[
					'code' => 'payment',
					'keyword' => 'payment_debit_discount',
					'value' => '5',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_installment_min',
					'value' => '5',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_installment_free',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_installment',
					'value' => '12',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_interest',
					'value' => '1,59',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_ticket_expiration_date',
					'value' => '2',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_ticket_discount',
					'value' => '5',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_ticket_demonstrative',
					'value' => 'teste',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'payment',
					'keyword' => 'payment_ticket_instructions',
					'value' => 'teste',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_email',
					'value' => 'andre.calistro@nerdweb.com.br',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_environment',
					'value' => 'sandbox',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_token',
					'value' => 'JNJ5WAA4NHWVANC8RIPQT5ZUMCAAER3F',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_key',
					'value' => '5XYT6ARSSDT9MX7IFUX4NEB2LTK4RAOEBMDLIT42',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_public_key',
					'value' =>
						'-----BEGIN PUBLIC KEY-----
						MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAg1CBMD6y37SGtJqL5WGC
						4p6glihC44fUfvd1a+TqQw+fK4FGfweYN3Knhenydr8h8spR8xmLhff5STg2kkg2
						RReiZhsQiL23gAVJY+1AbEbZ+stXMniboqAgTos/YEufQZLqPsiWqsx53fT7QVZi
						VRT2q/RrmUc4kVV85w0tuDWt+Dm00ZN8cYiID6iuzbTC96Ma/57SArvUUYqXH7aB
						hYZZpBatzibdRj6GteaGSR5wDqXulWqHQjVWf5oUgroAc3E1UQJ4a3D8nTG9KCoh
						gRhguBIEf5AnBddBYQA4OtsE7mxbYvQmKiSUAo7sSjNDfchF0k1nCKvbcRZHtrCj
						gQIDAQAB
						-----END PUBLIC KEY-----',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_waiting',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_in_analysis',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_approved_payment',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_authorized',
					'value' => '2',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_cancelled',
					'value' => '6',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_refunded',
					'value' => '6',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_reversed',
					'value' => '6',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'moip',
					'keyword' => 'moip_status_settled',
					'value' => '2',
					'created' => $date,
					'modified' => $date
				]
			])
			->save();

		$this->table('shipments')
			->insert([
				[
					'code' => 'correios',
					'keyword' => 'correios_zipcode_origin',
					'value' => '80620-010',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_additional_days',
					'value' => '2',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_status',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_contract_code',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_contract_password',
					'value' => '',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_services_04014',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				],
				[
					'code' => 'correios',
					'keyword' => 'correios_services_04510',
					'value' => '1',
					'created' => $date,
					'modified' => $date
				]
			])
			->save();
    }

    public function down()
    {
        $this->dropTable('attributes');
        $this->dropTable('banners');
        $this->dropTable('banners_images');
        $this->dropTable('bling_customers');
        $this->dropTable('bling_orders');
        $this->dropTable('bling_products');
        $this->dropTable('bling_providers');
        $this->dropTable('carts');
        $this->dropTable('categories');
        $this->dropTable('categories_visitors');
        $this->dropTable('customers');
        $this->dropTable('customers_addresses');
        $this->dropTable('customers_confirmations');
        $this->dropTable('customers_resets');
        $this->dropTable('email_logs');
        $this->dropTable('email_queues');
        $this->dropTable('email_statuses');
        $this->dropTable('email_templates');
        $this->dropTable('emails_marketings');
        $this->dropTable('faq_categories');
        $this->dropTable('faq_questions');
        $this->dropTable('filters');
        $this->dropTable('filters_groups');
        $this->dropTable('lendings');
        $this->dropTable('lendings_products');
        $this->dropTable('menus');
        $this->dropTable('orders');
        $this->dropTable('orders_histories');
        $this->dropTable('orders_products');
        $this->dropTable('orders_statuses');
        $this->dropTable('orders_types');
        $this->dropTable('pages');
        $this->dropTable('payments');
        $this->dropTable('payments_methods');
        $this->dropTable('positions');
        $this->dropTable('positions_pages');
        $this->dropTable('products');
        $this->dropTable('products_attributes');
        $this->dropTable('products_categories');
        $this->dropTable('products_conditions');
        $this->dropTable('products_filters');
        $this->dropTable('products_images');
        $this->dropTable('products_positions');
        $this->dropTable('products_relateds');
        $this->dropTable('products_sales');
        $this->dropTable('products_searches');
        $this->dropTable('products_statuses');
        $this->dropTable('products_tabs');
        $this->dropTable('products_variations');
        $this->dropTable('providers');
        $this->dropTable('rules');
        $this->dropTable('rules_menus');
        $this->dropTable('shipments');
        $this->dropTable('stocks_statuses');
        $this->dropTable('stores');
        $this->dropTable('testimonials');
        $this->dropTable('users');
        $this->dropTable('variations');
        $this->dropTable('variations_groups');
    }
}
