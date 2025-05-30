<?php

class Translator {
    private Database $database;
    private ?User $actor;
    private array $messages;
    private string $locale = DEFAULT_LOCALE;
    private bool $debugMode = false;
    private IntlDateFormatter $dateFormatter;
    private Collator $collator;

    public function __construct(Database $database, ?User $actor = null) {
        $this->database = $database;
        $this->actor = $actor;
        $this->setLocale(DEFAULT_LOCALE);
    }

    public function setLocale(string $locale): void {
        //$this->dateFormatter = new IntlDateFormatter(DEFAULT_LOCALE . '_' . strtoupper(DEFAULT_LOCALE), IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
        //$this->collator = collator_create(DEFAULT_LOCALE . '_' . strtoupper(DEFAULT_LOCALE));
        if ($locale === 'debug') {
            $this->debugMode = true;
            $this->messages = [];
        } else {
            $this->debugMode = false;
            $this->locale = $locale;
            $this->load();
        }
    }

    private function load(): void {
        $rows = $this->database->getRows("traductions_{$this->locale}");
        foreach ($rows as $row) {
            $this->messages[$row['trad']] = $row['value'];
        }
    }
    
    public function getMessage(string $key, array $variables = []): string {
        if ($this->debugMode) {
            return $key;
        }
        if (!isset($this->messages[$key])) {
            return "Missing Translation ($key, " . strtoupper($this->locale) . ")";
        }
        $message = $this->messages[$key];
        $message = preg_replace_callback('/{{(.*?)}}/', function ($matches) {
            $subKey = trim($matches[1]);
            return $this->getMessage($subKey);
        }, $message);
        $message = preg_replace_callback('/{(\w+)}/', function ($matches) use ($variables) {
            $varName = $matches[1];
            return $variables[$varName] ?? '{' . $varName . '}';
        }, $message);
        return $message;
    }


    public function getDateFormatter(): IntlDateFormatter {
        return $this->dateFormatter;
    }

    public function getCollator(): Collator {
        return $this->collator;
    }
}