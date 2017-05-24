<?php

namespace SI\API;

/**
 * This interface represents a DNS record.
 *
 * @package SI\API
 */
interface DNSRecordInterface
{
    /**
     * DNSRecordInterface constructor.
     *
     * @param mixed $rawRecord
     */
    public function __construct($rawRecord);

    /**
     * Load an external record.
     *
     * @param mixed $record
     * @param string $domain
     * @return DNSRecordInterface
     */
    public function load($record, string $domain): self;

    /**
     * Get the record.
     *
     * @return mixed
     */
    public function get();

    /**
     * Set the record data.
     *
     * @param array $record
     * @return DNSRecordInterface
     */
    public function set(array $record): self;

    /**
     * Get the domain the record is applied to.
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Get the domain identifier.
     *
     * @return mixed
     */
    public function getId();
}