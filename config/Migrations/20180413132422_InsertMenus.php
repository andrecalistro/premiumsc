<?php
use Migrations\AbstractMigration;

class InsertMenus extends AbstractMigration
{
	public function up()
	{
		/* Apaga os menus anteriores só pra garantir que não vai duplicar  */
		$menus = $this->fetchAll("SELECT * FROM menus WHERE name = 'Menus da Loja' OR name = 'Cupons de Desconto'");

		if ($menus) {
			foreach ($menus as $menu) {
				$this->execute("DELETE FROM menus WHERE id = $menu[id]");
				$this->execute("DELETE FROM rules_menus WHERE menus_id = $menu[id]");
			}
		}


		$date = date('Y-m-d H:i:s');

		// inserindo menu de menus da loja em CMS
		$menu_cms = $this->fetchRow("SELECT * FROM menus WHERE name = 'CMS'");
		$this->table('menus')
			->insert([
				['name' => 'Menus da Loja', 'icon' => '', 'parent_id' => $menu_cms['id'], 'plugin' => 'admin', 'controller' => 'stores-menus-groups', 'action' => 'index',
					'params' => '', 'status' => 1, 'position' => 13, 'created' => $date,	'modified' => $date]
			])
			->saveData();

		$menu_id = $this->getAdapter()->getConnection()->lastInsertId();
		$this->table('rules_menus')
			->insert([
				['rules_id' => 1, 'menus_id' => $menu_id, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => $menu_id, 'created' => $date, 'modified' => $date]
			])
			->saveData();


		// inserindo menu de cupons de desconto em Catálogo
		$menu_catalogo = $this->fetchRow("SELECT * FROM menus WHERE name = 'Catálogo'");
		$this->table('menus')
			->insert([
				['name' => 'Cupons de Desconto', 'icon' => '', 'parent_id' => $menu_catalogo['id'], 'plugin' => 'admin', 'controller' => 'coupons', 'action' => 'index',
					'params' => '', 'status' => 1, 'position' => 12, 'created'	=> $date, 'modified' => $date]
			])
			->saveData();

		$menu_id = $this->getAdapter()->getConnection()->lastInsertId();
		$this->table('rules_menus')
			->insert([
				['rules_id' => 1, 'menus_id' => $menu_id, 'created' => $date, 'modified' => $date],
				['rules_id' => 2, 'menus_id' => $menu_id, 'created' => $date, 'modified' => $date]
			])
			->saveData();
	}

	public function down()
	{
		$menus = $this->fetchAll("SELECT * FROM menus WHERE name = 'Menus da Loja' OR name = 'Cupons de Desconto'");

		if ($menus) {
			foreach ($menus as $menu) {
				$this->execute("DELETE FROM menus WHERE id = $menu[id]");
				$this->execute("DELETE FROM rules_menus WHERE menus_id = $menu[id]");
			}
		}
	}
}
