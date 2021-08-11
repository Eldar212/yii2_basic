<?php

use app\modules\swagger\assets\SwaggerAsset;
use yii\web\View;

/* @var $this View */
/* @var $restUrl string */

SwaggerAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <?php $this->head(); ?>
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }

        code {
            white-space: pre-wrap !important;
        }

        .swagger-ui .copy-to-clipboard {
            right: 120px;
        }

        .swagger-ui .download-contents {
            right: 30px;
        }

        .swagger-ui .model {
            border-spacing: 0 20px !important;
            border-collapse: separate !important;
        }
    </style>
</head>

<body>
<?php $this->beginBody(); ?>

<div id="swagger-ui"></div>

<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: "<?= $restUrl; ?>",
            dom_id: '#swagger-ui',
            deepLinking: true,
            jsonEditor: true,
            displayRequestDuration: true,
            filter: true,
            validatorUrl: false,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [],
            layout: "StandaloneLayout",
            onComplete: () => {
                dropElements();
                setButtons();
                switchButtons();
            },
            requestInterceptor: (request) => {
                let token = localStorage.getItem('token');
                if (token !== null) {
                    request.headers['X-Auth-Token'] = token;
                }

                return request;
            },
            responseInterceptor: (response) => {


                return response;
            }
        });
    };

    function dropElements() {
        let btnAuth_1 = document.querySelector('.authorize');
        btnAuth_1.remove();
    }

    function setButtons() {
        let authWrapper = document.querySelector('.auth-wrapper');
        let buttons = [
            {
                type: 'button',
                className: 'btn try-out__btn auth_a',
                style: 'border-color: #49cc90; margin-right: 5px;',
                innerHTML: 'Authorize',
                onclick: () => {
                    let token = prompt('Введите токен');
                    if (token !== null) {
                        localStorage.setItem('token', token);
                        switchButtons();
                    }
                }
            },
            {
                type: 'button',
                className: 'btn try-out__btn logout_a',
                style: 'border-color: #f93e3e; margin-right: 5px;',
                innerHTML: 'Logout',
                onclick: () => {
                    localStorage.removeItem('token');
                    switchButtons();
                }
            },
            {
                type: 'button',
                className: 'btn try-out__btn',
                style: 'border-color: #00a1ff;',
                innerHTML: 'Reset cache',
                onclick: () => {
                    let xhr = new XMLHttpRequest();
                    xhr.open('GET', 'swagger/drop-cache', false);
                    xhr.send();
                    if (xhr.status === 200) {
                        location.reload();
                    }
                }
            }
        ];

        buttons.forEach((element) => {
            let button = document.createElement(element.type);
            button.className = element.className;
            button.style = element.style;
            button.innerHTML = element.innerHTML;
            button.addEventListener('click', element.onclick);
            authWrapper.append(button);
        });
    }

    function switchButtons() {
        let authBtn = document.querySelector('.auth_a');
        let logoutBtn = document.querySelector('.logout_a');
        let token = localStorage.getItem('token');

        if (token !== null && token !== '') {
            authBtn.hidden = true;
            logoutBtn.hidden = false;
        } else {
            authBtn.hidden = false;
            logoutBtn.hidden = true;
        }
    }
</script>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
