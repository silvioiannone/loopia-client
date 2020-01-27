<?php

namespace SI\API\Loopia;

use SI\API\DNSRecordInterface;

/**
 * A Loopia DNS record.
 */
class DNSRecord implements DNSRecordInterface
{
    /**
     * The domain the record is applied to.
     */
    protected string $domain;

    /**
     * Record identifier.
     */
    protected int $id;

    /**
     * Time to live.
     */
    protected int $ttl;

    /**
     * Record type.
     */
    protected string $type;

    /**
     * Record priority.
     */
    protected int $priority;

    /**
     * Record value.
     */
    protected string $value;

    /**
     * DNSRecord constructor.
     */
    public function __construct($record = [])
    {
        if(! $record) {
            return;
        }

        $this->set($record);
    }

    /**
     * Set the record data.
     */
    public function set(array $record): DNSRecordInterface
    {
        $this->domain   = $record['domain'];
        $this->type     = $record['type'];
        $this->value    = $record['value'];
        $this->id       = $record['id'] ?? 0;
        $this->ttl      = $record['ttl'] ?? 3600;
        $this->priority = $record['priority'] ?? 0;

        return $this;
    }

    /**
     * Load an external record.
     */
    public function load($record, string $domain): DNSRecordInterface
    {
        $this->domain   = $domain;
        $this->type     = $record['type'];
        $this->value    = $record['rdata'];
        $this->id       = $record['record_id'] ?? 0;
        $this->ttl      = $record['ttl'] ?? 3600;
        $this->priority = $record['priority'] ?? 0;

        return $this;
    }

    /**
     * Get the record.
     */
    public function get(): array
    {
        $rawRecord = [];
        $rawRecord['ttl'] = $this->ttl;
        $rawRecord['type'] = $this->type;
        $rawRecord['priority'] = $this->priority;
        $rawRecord['rdata'] = $this->value;

        if($this->id) {
            $rawRecord['id'] = $this->id;
        }

        return $rawRecord;
    }

    /**
     * Get the domain the record is applied to.
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Get the domain identifier.
     */
    public function getId(): int
    {
        return $this->id;
    }
}
