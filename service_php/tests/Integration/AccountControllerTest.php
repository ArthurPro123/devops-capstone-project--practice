<?php
use PHPUnit\Framework\TestCase;
require_once PROJECT_ROOT . '/tests/factories/AccountFactory.php';

class AccountControllerTest extends TestCase
{
		private $baseUrl = 'http://localhost/devops/devops-capstone-project--practice/service_php';

    protected function setUp(): void
    {
        // Optionally, reset the database before each test
        $conn = getDBConnection();
        $conn->query("TRUNCATE TABLE accounts");
        $conn->close();
    }

    private function curlRequest($method, $endpoint, $data = null)
    {
        $ch = curl_init();
        $url = $this->baseUrl . $endpoint;
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ];
        if ($data) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'status' => $httpCode,
            'body' => json_decode($response, true)
        ];
    }

    public function testHealthEndpoint()
    {
        $result = $this->curlRequest('GET', '/health');
        $this->assertEquals(200, $result['status']);
        $this->assertEquals(['status' => 'OK'], $result['body']);
    }

    public function testCreateAccount()
    {
        $data = AccountFactory::create();
        $result = $this->curlRequest('POST', '/accounts', $data);
        $this->assertEquals(200, $result['status']);
        $this->assertTrue($result['body']['success']);
    }

    public function testGetAllAccounts()
    {
        $data = AccountFactory::create();
        $this->curlRequest('POST', '/accounts', $data);
        $result = $this->curlRequest('GET', '/accounts');
        $this->assertEquals(200, $result['status']);
        $this->assertCount(1, $result['body']);
    }

    public function testGetAccountById()
    {
        $data = AccountFactory::create();
        $this->curlRequest('POST', '/accounts', $data);
        $all = $this->curlRequest('GET', '/accounts');
        $id = $all['body'][0]['id'];
        $result = $this->curlRequest('GET', "/accounts/$id");
        $this->assertEquals(200, $result['status']);
        $this->assertEquals($data['name'], $result['body']['name']);
    }

    public function testUpdateAccount()
    {
        $data = AccountFactory::create();
        $this->curlRequest('POST', '/accounts', $data);
        $all = $this->curlRequest('GET', '/accounts');
        $id = $all['body'][0]['id'];
        $newData = AccountFactory::create(['name' => 'Updated Name']);
        $result = $this->curlRequest('PUT', "/accounts/$id", $newData);
        $this->assertEquals(200, $result['status']);
        $this->assertTrue($result['body']['success']);
    }

    public function testDeleteAccount()
    {
        $data = AccountFactory::create();
        $this->curlRequest('POST', '/accounts', $data);
        $all = $this->curlRequest('GET', '/accounts');
        $id = $all['body'][0]['id'];
        $result = $this->curlRequest('DELETE', "/accounts/$id");
        $this->assertEquals(200, $result['status']);
        $this->assertTrue($result['body']['success']);
    }
}
?>
