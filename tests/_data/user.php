<?php

use app\enums\UserStatus;

// $2y$13$CXT0Rkle1EMJ/c1l5bylL.EylfmQ39O5JlHJVFpNn618OUS1HwaIi

return [
    [
        'username'             => 'test',
        'auth_key'             => 'iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv',
        'password_hash'        => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK', //Test1234
        'password_reset_token' => 't5GU9NwpuGYSfb7FEZMAxqtuz2PkEvv_' . time(),
        'email'                => 'test@example.com',
        'status'               => UserStatus::STATUS_NOT_APPROVED,
        'created_at'           => '1391885313',
        'updated_at'           => '1391885313',
    ],
    [
        'username'             => 'test-approved',
        'auth_key'             => 'iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv',
        'password_hash'        => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK', //Test1234
        'password_reset_token' => 't5GU9NwpuGYSfb7FEZMAxqtuz2PkEvv_' . time(),
        'email'                => 'test-approved@example.com',
        'status'               => UserStatus::STATUS_APPROVED,
        'created_at'           => '1391885313',
        'updated_at'           => '1391885313',
    ],
    [
        'username'             => 'test-deleted',
        'auth_key'             => '4XXdVqi3rDpa_a6JH6zqVreFxUPcUPvJ',
        'password_hash'        => '$2y$13$d17z0w/wKC4LFwtzBcmx6up4jErQuandJqhzKGKczfWuiEhLBtQBK', //Test1234
        'password_reset_token' => '8mg3UX9AwdnWVd9LRnwNvH6d7WWkzNp_' . time(),
        'email'                => 'test3@example.com',
        'status'               => UserStatus::STATUS_DELETED,
        'created_at'           => '1548675330',
        'updated_at'           => '1548675330',
    ],
];
