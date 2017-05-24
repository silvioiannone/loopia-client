<?php

namespace SI\API;

/**
 * This interface represents a DNS manager provider.
 *
 * @package SI\API
 */
interface DNSProviderInterface
{
    /**
     * Set the credentials needed in order to authenticate.
     *
     * @param string $username
     * @param string $password
     * @return DNSProviderInterface
     */
    public function authenticate(string $username, string $password): self;

    /**
     * Add records to the specified domain.
     *
     * @param array $records
     * @return DNSProviderInterface
     */
    public function addRecords(array $records): DNSProviderInterface;

    /**
     * Add a record.
     *
     * @param DNSRecordInterface $record
     * @return DNSProviderInterface
     */
    public function addRecord(DNSRecordInterface $record): DNSProviderInterface;

    /**
     * Get the records for the specified domain.
     *
     * @param string $domain
     * @return array
     */
    public function getRecords(string $domain): array;

    /**
     * Delete the specified record.
     *
     * @param DNSRecordInterface $record
     * @return DNSProviderInterface
     */
    public function deleteRecord(DNSRecordInterface $record): self;

    /**
     * Add a subdomain.
     *
     * @param string $subdomain
     * @return self
     */
    public function addSubdomain(string $subdomain): self;

    /**
     * Retrieve the subdomains for the specified domain.
     *
     * @param string $domain
     * @return array
     */
    public function getSubdomains(string $domain): array;
}