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
    protected function setAbbreviations(): void
    {
        $abbreviations = collect($this->stateAbbreviations)->transform(function($state, $key) {
            return new KeyValue($key, $state);
        })->values()->toArray();

        $this->withMeta([
            'states' => $abbreviations,
            'abbreviations' => true
        ]);
    }

    /**
     * Uses the full name of each state as both the value and key
     * @param bool $useFullNames
     * @return $this
     */
    public function useFullNames(bool $useFullNames=true)
    {
        if ($useFullNames) {
            $fullStates = collect($this->fullStates)->transform(function($state) {
                return new KeyValue($state, $state);
            })->values()->toArray();

            return $this->withMeta([
                'states' => $fullStates,
                'abbreviations' => false
            ]);
        }

        return $this;
    }

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
//        'PR'=>'Puerto Rico',
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
//        'Puerto Rico',
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
}
