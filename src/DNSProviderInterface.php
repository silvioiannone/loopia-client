<?php

namespace SI\API;

/**
 * This interface represents a DNS manager provider.
 */
interface DNSProviderInterface
{
    /**
     * Set the credentials needed in order to authenticate.
     */
    public function authenticate(string $username, string $password): self;

    /**
     * Add records to the specified domain.
     */
    public function addRecords(array $records): DNSProviderInterface;

    /**
     * Add a record.
     */
    public function addRecord(DNSRecordInterface $record): DNSProviderInterface;

    /**
     * Get the records for the specified domain.
     */
    public function getRecords(string $domain): array;

    /**
     * Delete the specified record.
     */
    public function deleteRecord(DNSRecordInterface $record): self;

    /**
     * Add a subdomain.
     */
    public function addSubdomain(string $subdomain): self;

    /**
     * Retrieve the subdomains for the specified domain.
     */
    public function getSubdomains(string $domain): array;
}
