<?php

namespace SI\API\Loopia;

use SI\API\DNSRecordInterface;

/**
 * A Loopia DNS record.
 *
 * @package SI\API\Loopia
 */
class DNSRecord implements DNSRecordInterface
{
    /**
     * The domain the record is applied to.
     *
     * @var string
     */
    protected $domain;

    /**
     * Record identifier.
     *
     * @var integer
     */
    protected $id;

    /**
     * Time to live.
     *
     * @var integer
     */
    protected $ttl;

    /**
     * Record type.
     *
     * @var string
     */
    protected $type;

    /**
     * Record priority.
     *
     * @var integer
     */
    protected $priority;

    /**
     * Record value.
     *
     * @var string
     */
    protected $value;

    /**
     * DNSRecord constructor.
     *
     * @param array $record
     */
    public function __construct($record = [])
    {
        if(!$record) return;

        $this->set($record);
    }

    /**
     * Set the record data.
     *
     * @param array $record
     * @return mixed
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
     *
     * @param array $record
     * @param string $domain
     * @return DNSRecordInterface
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
     *
     * @return mixed
     */
    public function get()
    {
        $rawRecord = [];
        $rawRecord['ttl'] = $this->ttl;
        $rawRecord['type'] = $this->type;
        $rawRecord['priority'] = $this->priority;
        $rawRecord['rdata'] = $this->value;

        if($this->id)
        {
            $rawRecord['id'] = $this->id;
        }

        return $rawRecord;
    }

    /**
     * Get the domain the record is applied to.
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Get the domain identifier.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}