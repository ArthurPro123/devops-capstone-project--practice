<?php
use PHPUnit\Framework\TestCase;
require_once PROJECT_ROOT . '/tests/factories/AccountFactory.php';

class AccountTest extends TestCase
{
    private $account;
    private $conn;

    protected function setUp(): void
    {
        $this->account = new Account();
        $this->conn = getDBConnection();
        $this->conn->query("TRUNCATE TABLE accounts");
    }

    protected function tearDown(): void
    {
        $this->conn->query("TRUNCATE TABLE accounts");
        $this->conn->close();
    }

    public function testCreateAccount()
    {
        $data = AccountFactory::create();
        $result = $this->account->create($data['name'], $data['email'], $data['address'], $data['phone_number']);
        $this->assertTrue($result);
    }

    public function testGetAllAccounts()
    {
        $data = AccountFactory::create();
        $this->account->create($data['name'], $data['email'], $data['address'], $data['phone_number']);
        $accounts = $this->account->getAll();
        $this->assertCount(1, $accounts);
    }

    public function testGetAccountById()
    {
        $data = AccountFactory::create();
        $this->account->create($data['name'], $data['email'], $data['address'], $data['phone_number']);
        $accounts = $this->account->getAll();
        $account = $this->account->getById($accounts[0]['id']);
        $this->assertEquals($data['name'], $account['name']);
    }

    public function testUpdateAccount()
    {
        $data = AccountFactory::create();
        $this->account->create($data['name'], $data['email'], $data['address'], $data['phone_number']);
        $accounts = $this->account->getAll();
        $newData = AccountFactory::create(['name' => 'Updated Name']);
        $result = $this->account->update($accounts[0]['id'], $newData['name'], $newData['email'], $newData['address'], $newData['phone_number']);
        $this->assertTrue($result);
        $updated = $this->account->getById($accounts[0]['id']);
        $this->assertEquals('Updated Name', $updated['name']);
    }

    public function testDeleteAccount()
    {
        $data = AccountFactory::create();
        $this->account->create($data['name'], $data['email'], $data['address'], $data['phone_number']);
        $accounts = $this->account->getAll();
        $result = $this->account->delete($accounts[0]['id']);
        $this->assertTrue($result);
        $this->assertNull($this->account->getById($accounts[0]['id']));
    }
}
?>
