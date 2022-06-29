<?php

return [
    'accepted'             => ':attribute kabul edilmelidir.',
    'accepted_if'          => 'The :attribute must be accepted when :other is :value.',
    'active_url'           => ':attribute dogry URL bolmalydyr.',
    'after'                => ':attribute şundan has köne sene bolmalydyr :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute dine harplardan durmalydyr.',
    'alpha_dash'           => ':attribute dine harplardan, sanlardan we tirelerden durmalydyr.',
    'alpha_num'            => ':attribute dine harplardan we sanlardan durmalydyr.',
    'array'                => ':attribute ýygyndy bolmalydyr.',
    'before'               => ':attribute şundan has irki sene bolmalydyr :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'array'   => ':attribute :min - :max arasynda madda eýe bolmalydyr.',
        'file'    => ':attribute :min - :max kilobaýt arasynda bolmalydyr.',
        'numeric' => ':attribute :min - :max arasynda bolmalydyr.',
        'string'  => ':attribute :min - :max harplar arasynda bolmalydyr.',
    ],
    'boolean'              => ':attribute diňe dogry ýada ýalňyş bolmalydyr.',
    'confirmed'            => ':attribute tassyklamasy deň däl.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => ':attribute dogry sene bolmalydyr.',
    'date_equals'          => 'The :attribute must be a date equal to :date.',
    'date_format'          => ':attribute :format formatyna deň däl.',
    'declined'             => 'The :attribute must be declined.',
    'declined_if'          => 'The :attribute must be declined when :other is :value.',
    'different'            => ':attribute bilen :other birbirinden tapawutly bolmalydyr.',
    'digits'               => ':attribute :digits san bolmalydyr.',
    'digits_between'       => ':attribute :min bilen :max arasynda san bolmalydyr.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute formaty ýalňyş.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',
    'enum'                 => 'The selected :attribute is invalid.',
    'exists'               => 'Saýlanan :attribute ýalňyş.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => ':attribute meýdany zerur.',
    'gt'                   => [
        'array'   => 'The :attribute must have more than :value items.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string'  => 'The :attribute must be greater than :value characters.',
    ],
    'gte'                  => [
        'array'   => 'The :attribute must have :value items or more.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
    ],
    'image'                => ':attribute surat bolmalydyr.',
    'in'                   => ':attribute mukdary ýalňyş.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute san bolmalydyr.',
    'ip'                   => ':attribute dogry IP adres bolmalydyr.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'array'   => 'The :attribute must have less than :value items.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string'  => 'The :attribute must be less than :value characters.',
    ],
    'lte'                  => [
        'array'   => 'The :attribute must not have more than :value items.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal :value.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
    ],
    'mac_address'          => 'The :attribute must be a valid MAC address.',
    'max'                  => [
        'array'   => ':attribute iň az :max maddadan ybarat bolmalydyr.',
        'file'    => ':attribute :max kilobaýtdan kiçi bolmalydyr.',
        'numeric' => ':attribute :max den kiçi bolmalydyr.',
        'string'  => ':attribute :max harpdan kiçi bolmalydyr.',
    ],
    'mimes'                => ':attribute faýlň formaty :values bolmalydyr.',
    'mimetypes'            => ':attribute faýlň formaty :values bolmalydyr.',
    'min'                  => [
        'array'   => ':attribute iň az :min harpdan bolmalydyr.',
        'file'    => ':attribute mukdary :min kilobaýtdan köp bolmalydyr.',
        'numeric' => ':attribute mukdary :min dan köp bolmalydyr.',
        'string'  => ':attribute mukdary :min harpdan köp bolmalydyr.',
    ],
    'multiple_of'          => 'The :attribute must be a multiple of :value.',
    'not_in'               => 'Saýlanan :attribute geçersiz.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => ':attribute san bolmalydyr.',
    'password'             => 'The password is incorrect.',
    'present'              => 'The :attribute field must be present.',
    'prohibited'           => 'The :attribute field is prohibited.',
    'prohibited_if'        => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless'    => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits'            => 'The :attribute field prohibits :other from being present.',
    'regex'                => ':attribute formaty ýalňyş.',
    'required'             => ':attribute meýdany zerur.',
    'required_array_keys'  => 'The :attribute field must contain entries for: :values.',
    'required_if'          => ':attribute meýdany, :other :value hümmetine eýe bolanynda zerurdyr.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute meýdany :values bar bolanda zerurdyr.',
    'required_with_all'    => ':attribute meýdany haýsyda bolsa bir :values bar bolanda zerurdyr.',
    'required_without'     => ':attribute meýdany :values ýok bolanda zerurdyr.',
    'required_without_all' => ':attribute meýdany :values dan haýsyda bolsa biri ýok bolanda zerurdyr.',
    'same'                 => ':attribute bilen :other deň bolmalydyr.',
    'size'                 => [
        'array'   => ':attribute :size madda eýe bolmalydyr.',
        'file'    => ':attribute :size kilobaýt bolmalydyr.',
        'numeric' => ':attribute :size sandan ybarat bolmalydyr.',
        'string'  => ':attribute :size harp bolmalydyr.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'string'               => 'The :attribute must be a string.',
    'timezone'             => ':attribute dogry zolak bolmalydyr.',
    'unique'               => ':attribute önden hasaba alyndy.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute formaty ýalňyş.',
    'uuid'                 => 'The :attribute must be a valid UUID.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
];
