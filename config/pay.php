<?php

return [
    'alipay' => [
        'app_id'         => '2016092800619363',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkHpz9AOD5QXJAehNJYqoRTHXCTlgaQMDI8FbhDifQPDss8v7/yQmnvGv5dNgHUyCmDlz1SnHOrqTgTvB8rO3rdQyDJ4Ja1MX4wT+AzLY9nU/Aq4Udx7rJjnINsEZHTEnDDWD8fnHo5dCcTEjRwa7/2iam7XTR1b4D00CmzdR3sX2M3k/1A45DSq3BD0ppOyVgMHRC/prbj/hmWdpsC3WWD9q8cRCh9S5ltZXNQijQsWnLoycd6MtwrAyp286Yn7SheiLvuX3O4+MkUaDx2O4SgppN/EwOdw9rLp0lUQQbH2pyp0q9RY+OcDUbDBcU9pN+PlVFLzimhxcsD118RIJHQIDAQAB',
        'private_key'    => 'MIIEpAIBAAKCAQEAq4uV5pfYQbuTWoUyUXUZOl1N52wdx5ofZPhjGp9z9qSsWMfvSfyea6oPYXbBQf7D6roSRRFOQOkvZGoa89QACHgGRXzvy6dRhahe0OPIDQuAdndpEmZR29JiL7R0WGz5rTn1cQ/Z33kzbInmWZeNxa3NvyPGCZ3YaB3LdyTg2CyE6++37+v73x5MYW2zcuH2gUqZB2IfPZ5n6vNc53qGov0221Ep3jmUVwpKXXy07fHpW20/y1mxoJ1q1PfGtwNeeqlM6NZLOBLWzDYC3J+18TygTQbzwxcJuM1hh2eJ0gk5791YBsNa4P0R6+T9SPCpNukxc84V4XjGprVMiZfzlwIDAQABAoIBAEnDwxieEMLrOsjA38tBNDDxsC8kQYX0Ey3i1RK8oCvd0bJ3fsDs3N5lCSoa261aNLq5emOytliZLOTb720Lq1v46JF20NJcx2RW6zadzAc3++x1Gnxr/SUuSUREL4dajN5dPtp4O3Kp9l/kyGWcEr1/KCrZ4i1+b3EN5tD7zaeGgQIb+SrvNGbVJZLhpaB8/L2wAbvMtDMCWTzmnn39KmMh4CKMCGnIg5iA4wH618VtvPpgCSDdPIDnI5G5JzN7F7B6VNZdF6IkL7fx0aGbRFan84h2CVrZ1jMrccr+aS4n2+qJQ9TB9TIm694yvo27iCgYUp9/KfILNnSvhnwG6ckCgYEA04PFJ6pSf4Z1SMH/XoY8wAZX5TiZdqjdEpljNHn6fxnBgAuih2k/BcJEpRe8Y7q6ntsoBp29BpFGufQLfeBq4LJ+hJVPN8U9g6RbNBxwAWvTwsDQzyCcRu1l6FfoHOMjMamD6fQiKYMiC2TTOb7SJ2VRZ9Jroew20wTU50bc7YUCgYEAz5/Oh5jsyMCtete7gYRmOv0r4hfaRc2EWWd5sHUGXwzHOc9KPwYP5rcbDx88Yah11ONClZnflnJeN6busUgpsMsQlL2A+LGUPP+Py3CzeukGC+Z5scROnuKJHxEjAH/0I6tBFxnfI1JRUaSrRRDdBUUAo6a6XX230qhogGh7CWsCgYEAubl4ws2Rxxx/m7WM0Kk6arqnL0U1q7W2+P/q1kdNJ5GsEQ0mV5SYnCvrLrPa3g82kwqI6NZVBpFF8z5RYORPtKHG6hBZEPWGgDMvSmC2EOlndhjswRM3ZihKVWvrCoJ/groAdMvDu4PDvxF3T7s4uRMEGg/wJqxNr5kMgU/96ikCgYBCyRvtIDLibKAhCK4G/mjIBtIL2zJaC77L524MZchT4M9g+B3g4flRdIretWR94WttvGCZsLJsOYO3ERpsqlLGzLsbrU2EMdMGQAqoHSuOmNBaGZwBo6zKjQIgnSmOKpqEsrywSqEtQnhn87kn8UG3RTfsbGA8XIk52PQsge852wKBgQDDBOUOAA0m19784ZLhMbjHRnLyQ2rHa/PWuZY04EOQ/n1Q4V4FNH0j2a/Um1dStsVA6jocYlP1TCOHIQOC4UrYxixNywIfkiQkB/c81erxkeTwaUsvL7mxGVz2+YqNnNDhqsuItpU1NlMA6bulWR8yEmJNR3kishYVHh4FDf/6dQ==',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];