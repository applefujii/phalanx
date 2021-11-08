<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeが有効なURLではありません。',
    'after'                => ':attributeには、:dateより後の日時を指定してください。',
    'after_or_equal'       => ':attributeには、:date以降の日時を指定してください。',
    'alpha'                => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash'           => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num'            => ':attributeはアルファベット数字がご利用できます。',
    'array'                => ':attributeは配列でなくてはなりません。',
    'before'               => ':attributeには、:dateより前の日時をご利用ください。',
    'before_or_equal'      => ':attributeには、:date以前の日時をご利用ください。',
    'between'              => [
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'file'    => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'string'  => ':attributeは、:min文字から、:max文字の間で指定してください。',
        'array'   => ':attributeは、:min個から:max個の間で指定してください。',
    ],
    'boolean'              => ':attributeを選択してください。',
    'confirmed'            => ':attributeと、確認フィールドとが、一致していません。',
    'date'                 => ':attributeが有効な日付ではありません。',
    'date_equals'          => ':attributeには、:dateと同じ日時を指定してください。',
    'date_format'          => ':attributeは:format形式で⼊⼒してください。',
    'different'            => ':attributeと:otherには、異なった内容を指定してください。',
    'digits'               => ':attributeは半⾓数字:digits桁で⼊⼒してください。',
    'digits_between'       => ':attributeは半⾓数字:min～:max桁で⼊⼒してください。',
    'dimensions'           => ':attributeの図形サイズが正しくありません。',
    'distinct'             => ':attributeには異なった値を指定してください。',
    'email'                => ':attributeに誤りがあります。',
    'ends_with'            => ':attributeには、:valuesのどれかで終わる値を指定してください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeにファイルを添付してください。',
    'filled'               => ':attributeに値を指定してください。',
    'gt'                   => [
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'file'    => ':attributeには、:value kBより大きなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より長く指定してください。',
        'array'   => ':attributeには、:value個より多くのアイテムを指定してください。',
    ],
    'gte'                  => [
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'file'    => ':attributeには、:value kB以上のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以上で指定してください。',
        'array'   => ':attributeには、:value個以上のアイテムを指定してください。',
    ],
    'image'                => ':attributeにファイルを添付してください。',
    'in'                   => ':attributeの選択に誤りがあります。',
    'in_array'             => ':attributeには:otherの値を指定してください。',
    'integer'              => ':attributeは半⾓数字の整数で⼊⼒してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json'                 => ':attributeには、有効なJSON文字列を指定してください。',
    'lt'                   => [
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'file'    => ':attributeには、:value kBより小さなファイルを指定してください。',
        'string'  => ':attributeは、:value文字より短く指定してください。',
        'array'   => ':attributeには、:value個より少ないアイテムを指定してください。',
    ],
    'lte'                  => [
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'file'    => ':attributeには、:value kB以下のファイルを指定してください。',
        'string'  => ':attributeは、:value文字以下で指定してください。',
        'array'   => ':attributeには、:value個以下のアイテムを指定してください。',
    ],
    'max'                  => [
        'numeric' => ':attributeは半⾓数字:max以下で⼊⼒してください。',
        'file'    => ':attributeは:max kB以下のファイルを添付してください。',
        'string'  => ':attributeは:max⽂字以下で⼊⼒してください。',
        'array'   => ':attributeは:max個以下指定してください。',
    ],
    'mimes'                => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':attributeには:valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeは半⾓数字:min以上で⼊⼒してください。',
        'file'    => ':attributeは:min kB以上のファイルを添付してください。',
        'string'  => ':attributeは:min文字以上で⼊⼒してください。',
        'array'   => ':attributeは:min個以上指定してください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式が正しくありません。',
    'numeric'              => ':attributeは半⾓数字で⼊⼒してください。',
    'present'              => ':attributeが存在していません。',
    'regex'                => ':attributeの形式が正しくありません。',
    'required'             => ':attributeを⼊⼒してください。',
    'required_if'          => ':otherが:valueの場合、:attributeを⼊⼒してください。',
    'required_unless'      => ':otherが:valuesでない場合、:attributeを入力してください。',
    'required_with'        => ':valuesを入力する場合、:attributeも入力してください。',
    'required_with_all'    => ':valuesを入力する場合、:attributeも入力してください。',
    'required_without'     => ':valuesを入力しない場合、:attributeを入力してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを入力してください。',
    'same'                 => ':attributeと:otherには同じ値を入力してください。',
    'size'                 => [
        'numeric' => ':attributeは半⾓数字:sizeを⼊⼒してください。',
        'file'    => ':attributeは:size kBのファイルを添付してください。',
        'string'  => ':attributeは:size文字で指定してください。',
        'array'   => ':attributeは:size個指定してください。',
    ],
    'starts_with'          => ':attributeには、:valuesのどれかで始まる値を指定してください。',
    'string'               => ':attributeは⽂字列を⼊⼒してください。',
    'timezone'             => ':attributeには、有効なゾーンを指定してください。',
    'unique'               => ':attributeはすでに登録されています。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeに正しい形式を指定してください。',
    'uuid'                 => ':attributeに有効なUUIDを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | '属性.ルール'の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        '属性名' => [
            'ルール名' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば'email'の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */

    'attributes' => [
        // 体験・見学申込
        'name' => '氏名',
        'name_kana' => '氏名（カナ）',
        'office_id' => '事業所',
        'desired_date' => '体験・見学希望日',
        'email' => 'メールアドレス',
        'phone_number' => '電話番号',

        // 適性診断
        'answers' => '回答',
        'answers.*' => '回答',
        'question' => '質問文',
        'questions' => '質問文',
        'questions.*' => '質問文',
        'sort' => '表示順',
        'sorts' => '表示順',
        'sorts.*' => '表示順',
        'score_apple' => '点数',
        'score_apples' => '点数',
        'score_apples.*' => '点数',
        'score_mint' => '点数',
        'score_mints' => '点数',
        'score_mints.*' => '点数',
        'score_maple' => '点数',
        'score_maples' => '点数',
        'score_maples.*' => '点数',

        // ユーザーマスター追加
        'user_type_id' => 'ユーザー種別',
        'name_katakana' => '氏名（カナ）',
        'login_name' => 'ログイン名',
        'password' => 'パスワード'
    ]

];