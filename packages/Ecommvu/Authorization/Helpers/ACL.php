<?php

namespace Ecommvu\Authorization\Helpers;

/**
 * Scope implementation
 */
class ACL
{
    /**
     * Holds raw and scopes
     *
     * @var Array
     */
    protected $scopes;

    /**
     * Holds auto grouped scopes
     *
     * @var Array
     */
    protected $groupedScopes;

    /**
     * Constructor to inject dependencies
     */
    public function __construct()
    {
        $this->scopes = config('scopes');
    }

    /**
     * Collect dotted scopes - recursive method which write child until dot exists
     */
    protected function collectScopes($delimiter = '.')
    {
        $this->groupedScopes = [];

        foreach ($this->scopes as $notations => $value) {
            // extract keys
            $keys = explode($delimiter, $notations);
            // reverse keys for assignments
            $keys = array_reverse($keys);

            // set initial value
            $lastVal = $value;
            foreach ($keys as $key) {
                // wrap value with key over each iteration
                $lastVal = [
                    $key => $lastVal
                ];
            }

            // merge result
            $this->groupedScopes = array_merge_recursive($this->groupedScopes, $lastVal);
        }

        return $this->groupedScopes;
    }

    /**
     * Process scopes into sensible groups
     *
     * @return void
     */
    public function groupScopes()
    {
        if ($this->validateScopes()) {
            return $this->collectScopes();
        } else {
            $this->scopes = [];

            return $this->scopes;
        }
    }

    /**
     * To validate all scopes and keys
     */
    public function validateScopes()
    {
        $iterator = new \RecursiveArrayIterator($this->scopes);

        while ($iterator->valid()) {
            if (! preg_match(
                '/^([(a-z)])([(_)a-z.a-z(\w.*)])*$/',
                $iterator->key()
            )
            ) {
                throw new \Exception('Scope tokens validation failed');
            }

            foreach (
                [
                '__', '..', '._', '_.', '(', ')', '*.', '**', '$', '!'
                ]
                as
                $negExpectation
            ) {
                if (str_contains($iterator->key(), $negExpectation)) {
                    throw new \Exception('Scope tokens validation failed');
                }
            }

            if ($iterator->hasChildren()) {
                foreach ($iterator->getChildren() as $key => $value) {
                    if (str_contains('.', $value)) {
                        throw new \Exception('Scope tokens validation failed');
                    }
                }
            }

            $iterator->next();
        }

        return true;
    }
}
