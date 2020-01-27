<?php

namespace SI\API;

use Laminas\XmlRpc\Client;
use SI\API\Loopia\DNSRecord;

/**
 * Loopia API client.
 */
class Loopia implements DNSProviderInterface
{
    protected const BASE_URL = 'https://api.loopia.se/RPCSERV';

    /**
     * Username.
     */
    protected string $username;

    /**
     * Password
     */
    protected string $password;

    /**
     * XML-RPC Client.
     */
    protected Client $XMLRPCClient;

    /**
     * Loopia constructor.
     */
    public function __construct()
    {
        $this->XMLRPCClient = new Client(self::BASE_URL);
    }

    /**
     * Set the credentials needed in order to call some Loopia methods.
     */
    public function authenticate(string $username, string $password): DNSProviderInterface
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    /**
     * Add records to the specified domain.
     */
    public function addRecords(array $records): DNSProviderInterface
    {
        foreach($records as $record)
        {
            $this->addRecord($record);
        }

        return $this;
    }

    /**
     * Add a record to the specified domsin.
     */
    public function addRecord(DNSRecordInterface $record): DNSProviderInterface
    {
        [, $subdomain, $domain] = $this->extractDomainParts($record->getDomain());

        $this->call('addZoneRecord', [
            $this->username,
            $this->password,
            $domain,
            $subdomain,
            $record->get()
        ]);

        return $this;
    }

    /**
     * Get the records for the specified domain.
     *
     * @return DNSRecord[]
     */
    public function getRecords(string $domain): array
    {
        [, $subdomain, $topDomain] = $this->extractDomainParts($domain);

        $records = $this->call('getZoneRecords', [
            $this->username,
            $this->password,
            $topDomain,
            $subdomain
        ]);

        return $this->loadRecords($records, $domain);
    }

    /**
     * Delete the specified record.
     */
    public function deleteRecord(DNSRecordInterface $record): DNSProviderInterface
    {
        [, $subdomain, $domain] = $this->extractDomainParts($record->getDomain());

        $this->call('removeZoneRecord', [
            $this->username,
            $this->password,
            $domain,
            $subdomain,
            $record->getId()
        ]);

        return $this;
    }

    /**
     * Add a subdomain.
     *
     * @param string $subdomain 'foo.bar.com'
     */
    public function addSubdomain(string $subdomain): DNSProviderInterface
    {
        [, $subdomain, $domain] = $this->extractDomainParts($subdomain);

        if(in_array($subdomain, $this->getSubdomains($domain)))
        {
            return $this;
        }

        $this->call('addSubdomain', [
            $this->username,
            $this->password,
            $domain,
            $subdomain
        ]);

        return $this;
    }

    /**
     * Retrieve the subdomains for the specified domain. Requires authentication.
     */
    public function getSubdomains(string $domain): array
    {
        return $this->call('getSubdomains', [
            $this->username,
            $this->password,
            $domain
        ]);
    }

    /**
     * Call a Loopia method.
     *
     * @return mixed
     */
    protected function call(string $method, array $parameters = [])
    {
        return $this->XMLRPCClient->call($method, $parameters);
    }

    /**
     * Load the raw DNS records into a DNSRecordInterface compatible object.
     *
     * @return DNSRecord[]
     */
    protected function loadRecords(array $rawRecords, string $domain): array
    {
        $records = [];

        foreach ($rawRecords as $rawRecord)
        {
            $record = $rawRecord;
            if (isset($rawRecord['rdata']))
            {
                $record['value'] = $rawRecord['rdata'];
            }
            $records[] = $this->loadRecord($record, $domain);
        }

        return $records;
    }

    /**
     * Load the raw DNS records into a DNSRecordInterface compatible object.
     */
    protected function loadRecord(array $record, string $domain): DNSRecordInterface
    {
        return (new DNSRecord())->load($record, $domain);
    }

    /**
     * Extract the top main domain and the subdomain from the selected domain.
     *
     * @return array An array: [$domain, $subdomain]
     */
    protected function extractDomainParts(string $domain): array
    {
        // Separate the domain from the subdomain: "foo.bar.bloom.se" => ["foo.bar", "bloom.se"]
        preg_match('/(?:\.*(.*)\.)?(.+\..+)$/', $domain, $matches);

        return $matches;
    }
}
