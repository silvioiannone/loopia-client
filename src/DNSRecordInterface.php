<?php

namespace SI\API;

/**
 * This interface represents a DNS record.
 */
interface DNSRecordInterface
{
    /**
     * DNSRecordInterface constructor.
     */
    public function __construct($rawRecord);

    /**
     * Load an external record.
     */
    public function load($record, string $domain): self;

    /**
     * Get the record.
     */
    public function get(): array;

    /**
     * Set the record data.
     */
    public function set(array $record): self;

    /**
     * Get the domain the record is applied to.
     */
    public function getDomain(): string;

    /**
     * Get the domain identifier.
     */
    public function getId();
}
