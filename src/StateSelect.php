<?php

namespace Dniccum\StateSelect;

use Laravel\Nova\Fields\Field;

class StateSelect extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-state-select';

    /**
     * @var bool $useFullNames
     */
    private $useFullNames = false;

    /**
     * @var array|string[]
     */
    private $stateList = [];

    /**
     * @param $resource
     * @param null $attribute
     * @return mixed
     */
    public function resolve($resource, $attribute = null)
    {
        $this->setAbbreviations();

        return parent::resolve($resource, $attribute);
    }

    /**
     * Initial set up
     *
     * @return void
     */
    private function setAbbreviations(): void
    {
        if (count($this->stateList) === 0) {
            $this->stateList = collect($this->stateAbbreviations)->transform(function($state, $key) {
                return new KeyValue($key, $state);
            })->values()->toArray();

            $this->withMeta([
                'states' => $this->stateList,
                'abbreviations' => true
            ]);
        }
    }

    /**
     * Uses the full name of each state as both the value and key
     * @param bool $useFullNames
     * @return $this
     */
    public function useFullNames(bool $useFullNames=true)
    {
        $this->useFullNames = $useFullNames;

        if ($useFullNames) {
            $this->stateList = collect($this->fullStates)->transform(function($state) {
                return new KeyValue($state, $state);
            })->values()->toArray();

            return $this->withMeta([
                'states' => $this->stateList,
                'abbreviations' => false
            ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function includeTerritories()
    {
        if ($this->useFullNames) {
            if (count($this->stateList) === 0) {
                $this->useFullNames();
            }

            $territories = collect($this->fullTerritories)->transform(function($territory) {
                return new KeyValue($territory, $territory);
            })->values();
        } else {
            if (count($this->stateList) === 0) {
                $this->setAbbreviations();
            }

            $territories = collect($this->territories)->transform(function($territory, $abbreviation) {
                return new KeyValue($abbreviation, $territory);
            })->values();
        }

        $this->stateList = collect($this->stateList)
            ->merge($territories)
            ->sortBy('value')
            ->unique()
            ->values()
            ->toArray();

        return $this->withMeta([
            'states' => $this->stateList
        ]);
    }

    public function customValues(array $customValues)
    {
        if ($this->useFullNames) {
            if ($this->isAssoc($customValues)) {
                return abort(500, 'The custom values provided cannot be an associative array.');
            }
            if (count($this->stateList) === 0) {
                $this->useFullNames();
            }

            $customValueCollection = collect($customValues)->transform(function($value) {
                return new KeyValue($value, $value);
            })->values();
        } else {
            if (!$this->isAssoc($customValues)) {
                return abort(500, 'The custom values must be an associative array.');
            }
            if (count($this->stateList) === 0) {
                $this->setAbbreviations();
            }

            $customValueCollection = collect($customValues)->transform(function($value, $key) {
                return new KeyValue($key, $value);
            })->values();
        }

        $this->stateList = collect($this->stateList)
            ->merge($customValueCollection)
            ->sortBy('value')
            ->unique()
            ->values()
            ->toArray();

        return $this->withMeta([
            'states' => $this->stateList
        ]);
    }

    /**
     * @param array $arr
     * @return bool
     */
    private function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * @var array $stateAbbreviations
     */
    private $stateAbbreviations = [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District of Columbia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming'
    ];

    /**
     * @var array $fullStates
     */
    private $fullStates = [
        'Alabama',
        'Alaska',
        'Arizona',
        'Arkansas',
        'California',
        'Colorado',
        'Connecticut',
        'Delaware',
        'District of Columbia',
        'Florida',
        'Georgia',
        'Hawaii',
        'Idaho',
        'Illinois',
        'Indiana',
        'Iowa',
        'Kansas',
        'Kentucky',
        'Louisiana',
        'Maine',
        'Maryland',
        'Massachusetts',
        'Michigan',
        'Minnesota',
        'Mississippi',
        'Missouri',
        'Montana',
        'Nebraska',
        'Nevada',
        'New Hampshire',
        'New Jersey',
        'New Mexico',
        'New York',
        'North Carolina',
        'North Dakota',
        'Ohio',
        'Oklahoma',
        'Oregon',
        'Pennsylvania',
        'Rhode Island',
        'South Carolina',
        'South Dakota',
        'Tennessee',
        'Texas',
        'Utah',
        'Vermont',
        'Virginia',
        'Washington',
        'West Virginia',
        'Wisconsin',
        'Wyoming'
    ];

    private $territories = [
        'AS' => 'American Samoa',
        'DC' => 'District of Columbia',
        'FM' => 'Federated States of Micronesia',
        'GU' => 'Guam',
        'MH' => 'Marshall Islands',
        'MP' => 'Northern Mariana Islands',
        'PW' => 'Palau',
        'PR' => 'Puerto Rico',
        'VI' => 'Virgin Islands',
        'AE' => 'Armed Forces Africa',
        'AA' => 'Armed Forces Americas',
        'AP' => 'Armed Forces Pacific',
    ];

    private $fullTerritories = [
        'American Samoa',
        'District of Columbia',
        'Federated States of Micronesia',
        'Guam',
        'Marshall Islands',
        'Northern Mariana Islands',
        'Palau',
        'Puerto Rico',
        'Virgin Islands',
        'Armed Forces Africa',
        'Armed Forces Americas',
        'Armed Forces Pacific',
    ];
}
