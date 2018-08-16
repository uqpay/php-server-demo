$(function init() {
    function post(url, data) {
        return $.ajax(url, {
            contentType: 'application/json',
            type: "POST",
            data: JSON.stringify(data || {}),
        }).fail(function (error) {
            console.log(error);
            alert((error.responseJSON && error.responseJSON.message));
        });
    }
    function formPost(action, data) {
        const form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', action);
        form.className = 'hidden';
        Object.keys(data).forEach(function (key) {
            const input = document.createElement('input');
            input.setAttribute('name', key);
            input.setAttribute('value', data[key]);
            form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
    }
    const countries = [{ code: 'DE', name: 'Germany', name_zh_cn: '德国' }, { code: 'PR', name: 'Puerto Rico', name_zh_cn: '波多黎哥' }, {
        code: 'TW',
        name: 'Taiwan(China)',
        name_zh_cn: '中国台湾',
    }, { code: 'HK', name: 'Hong Kong(China)', name_zh_cn: '中国香港' }, { code: 'PT', name: 'Portugal', name_zh_cn: '葡萄牙' }, {
        code: 'HN',
        name: 'Honduras',
        name_zh_cn: '洪都拉斯',
    }, { code: 'DK', name: 'Denmark', name_zh_cn: '丹麦' }, { code: 'LT', name: 'Lithuania', name_zh_cn: '立陶宛' }, {
        code: 'PY',
        name: 'Paraguay',
        name_zh_cn: '巴拉圭',
    }, { code: 'LU', name: 'Luxembourg', name_zh_cn: '卢森堡' }, { code: 'HR', name: 'Croatia', name_zh_cn: '克罗地亚' }, {
        code: 'LV',
        name: 'Latvia',
        name_zh_cn: '拉脱维亚',
    }, { code: 'DO', name: 'Dominican Republic', name_zh_cn: '多米尼加共和国' }, { code: 'YE', name: 'Yemen', name_zh_cn: '也门' }, {
        code: 'UA',
        name: 'Ukraine',
        name_zh_cn: '乌克兰',
    }, { code: 'HU', name: 'Hungary', name_zh_cn: '匈牙利' }, { code: 'LY', name: 'Libya', name_zh_cn: '利比亚' }, {
        code: 'QA',
        name: 'Qatar',
        name_zh_cn: '卡塔尔',
    }, { code: 'MA', name: 'Morocco', name_zh_cn: '摩洛哥' }, { code: 'DZ', name: 'Algeria', name_zh_cn: '阿尔及利亚' }, {
        code: 'ME',
        name: 'Montenegro',
        name_zh_cn: '黑山',
    }, { code: 'ID', name: 'Indonesia', name_zh_cn: '印度尼西亚' }, { code: 'IE', name: 'Ireland', name_zh_cn: '爱尔兰' }, {
        code: 'US',
        name: 'United States',
        name_zh_cn: '美国',
    }, { code: 'EC', name: 'Ecuador', name_zh_cn: '厄瓜多尔' }, { code: 'MK', name: 'Macedonia', name_zh_cn: '马其顿王国' }, {
        code: 'EE',
        name: 'Estonia',
        name_zh_cn: '爱沙尼亚',
    }, { code: 'EG', name: 'Egypt', name_zh_cn: '埃及' }, { code: 'IL', name: 'Israel', name_zh_cn: '以色列' }, {
        code: 'AE',
        name: 'United Arab Emirates',
        name_zh_cn: '阿拉伯联合酋长国',
    }, { code: 'UY', name: 'Uruguay', name_zh_cn: '乌拉圭' }, { code: 'IN', name: 'India', name_zh_cn: '印度' }, { code: 'MT', name: 'Malta', name_zh_cn: '马耳他' }, {
        code: 'ZA',
        name: 'South Africa',
        name_zh_cn: '南非',
    }, { code: 'IQ', name: 'Iraq', name_zh_cn: '伊拉克' }, { code: 'IS', name: 'Iceland', name_zh_cn: '冰岛' }, { code: 'MX', name: 'Mexico', name_zh_cn: '墨西哥' }, {
        code: 'AL',
        name: 'Albania',
        name_zh_cn: '阿尔巴尼亚',
    }, { code: 'IT', name: 'Italy', name_zh_cn: '意大利' }, { code: 'MY', name: 'Malaysia', name_zh_cn: '马来西亚' }, {
        code: 'ES',
        name: 'Spain',
        name_zh_cn: '西班牙',
    }, { code: 'VE', name: 'Venezuela', name_zh_cn: '委内瑞拉' }, { code: 'AR', name: 'Argentina', name_zh_cn: '阿根廷' }, {
        code: 'AT',
        name: 'Austria',
        name_zh_cn: '奥地利',
    }, { code: 'AU', name: 'Australia', name_zh_cn: '澳大利亚' }, { code: 'VN', name: 'Vietnam', name_zh_cn: '越南' }, {
        code: 'NI',
        name: 'Nicaragua',
        name_zh_cn: '尼加拉瓜',
    }, { code: 'RO', name: 'Romania', name_zh_cn: '罗马尼亚' }, { code: 'NL', name: 'Netherlands', name_zh_cn: '荷兰' }, {
        code: 'BA',
        name: 'Bosnia and Herzegovina',
        name_zh_cn: '波斯尼亚和黑山共和国',
    }, { code: 'NO', name: 'Norway', name_zh_cn: '挪威' }, { code: 'RS', name: 'Serbia', name_zh_cn: '塞尔维亚' }, {
        code: 'BE',
        name: 'Belgium',
        name_zh_cn: '比利时',
    }, { code: 'FI', name: 'Finland', name_zh_cn: '芬兰' }, { code: 'RU', name: 'Russia', name_zh_cn: '俄罗斯' }, {
        code: 'JO',
        name: 'Jordan',
        name_zh_cn: '约旦',
    }, { code: 'BG', name: 'Bulgaria', name_zh_cn: '保加利亚' }, { code: 'BH', name: 'Bahrain', name_zh_cn: '巴林' }, {
        code: 'JP',
        name: 'Japan',
        name_zh_cn: '日本',
    }, { code: 'NZ', name: 'New Zealand', name_zh_cn: '新西兰' }, { code: 'FR', name: 'France', name_zh_cn: '法国' }, {
        code: 'BO',
        name: 'Bolivia',
        name_zh_cn: '玻利维亚',
    }, { code: 'SA', name: 'Saudi Arabia', name_zh_cn: '沙特阿拉伯' }, { code: 'BR', name: 'Brazil', name_zh_cn: '巴西' }, {
        code: 'SD',
        name: 'Sudan',
        name_zh_cn: '苏丹',
    }, { code: 'SE', name: 'Sweden', name_zh_cn: '瑞典' }, { code: 'SG', name: 'Singapore', name_zh_cn: '新加坡' }, {
        code: 'SI',
        name: 'Slovenia',
        name_zh_cn: '斯洛文尼亚',
    }, { code: 'BY', name: 'Belarus', name_zh_cn: '白俄罗斯' }, { code: 'SK', name: 'Slovakia', name_zh_cn: '斯洛伐克' }, {
        code: 'GB',
        name: 'United Kingdom',
        name_zh_cn: '英国',
    }, { code: 'OM', name: 'Oman', name_zh_cn: '阿曼' }, { code: 'CA', name: 'Canada', name_zh_cn: '加拿大' }, {
        code: 'SV',
        name: 'El Salvador',
        name_zh_cn: '萨尔瓦多',
    }, { code: 'CH', name: 'Switzerland', name_zh_cn: '瑞士' }, { code: 'SY', name: 'Syria', name_zh_cn: '叙利亚' }, {
        code: 'KR',
        name: 'South Korea',
        name_zh_cn: '韩国',
    }, { code: 'CL', name: 'Chile', name_zh_cn: '智利' }, { code: 'GR', name: 'Greece', name_zh_cn: '希腊' }, { code: 'CN', name: 'China', name_zh_cn: '中国' }, {
        code: 'CO',
        name: 'Colombia',
        name_zh_cn: '哥伦比亚',
    }, { code: 'KW', name: 'Kuwait', name_zh_cn: '科威特' }, { code: 'GT', name: 'Guatemala', name_zh_cn: '危地马拉' }, {
        code: 'CR',
        name: 'Costa Rica',
        name_zh_cn: '哥斯达黎加',
    }, { code: 'CS', name: 'Serbia and Montenegro', name_zh_cn: '塞尔维亚及黑山' }, { code: 'PA', name: 'Panama', name_zh_cn: '巴拿马' }, {
        code: 'CU',
        name: 'Cuba',
        name_zh_cn: '古巴',
    }, { code: 'TH', name: 'Thailand', name_zh_cn: '泰国' }, { code: 'PE', name: 'Peru', name_zh_cn: '秘鲁' }, {
        code: 'CY',
        name: 'Cyprus',
        name_zh_cn: '塞浦路斯',
    }, { code: 'LB', name: 'Lebanon', name_zh_cn: '黎巴嫩' }, { code: 'CZ', name: 'Czech Republic', name_zh_cn: '捷克共和国' }, {
        code: 'PH',
        name: 'Philippines',
        name_zh_cn: '菲律宾',
    }, { code: 'TN', name: 'Tunisia', name_zh_cn: '突尼斯' }, { code: 'PL', name: 'Poland', name_zh_cn: '波兰' }, { code: 'TR', name: 'Turkey', name_zh_cn: '土耳其' }];
    // 支付方式选择
    const $methodSelect = $('#method').selectMatch();
    //数字键盘
    const $amount = $("#amount");
    $amount.value = '0';
    function renderAmount(value) {
        if ($amount.value.length >= 15) {
            return;
        }
        switch (value.toString()) {
            case 'back':
                $amount.value = $amount.value ? $amount.value.substring(0, $amount.value.length - 1) : '0';
                break;
            case '.':
                if ($amount.value.indexOf('.') < 0) {
                    $amount.value += value;
                }
                break;
            case '0':
                if ($amount.value !== '0') {
                    $amount.value += value;
                }
                break;
            case '1':
            case '2':
            case '3':
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':
                if ($amount.value === '0') {
                    $amount.value = value.toString();
                } else {
                    $amount.value += value;
                }
                break;
            default:
                break;
        }
        $amount.text($amount.value);
    }
    $('p[data-keyboard]').click(function () {
        const $this = $(this);
        const type = $this.data('keyboard');
        const key = $this.data('key');
        if (type === 'num') {
            renderAmount(key);
        } else if (type === 'back') {
            renderAmount('back');
        }
    });

    $('#submit').click(function () {
        if (!$amount.value || $amount.value === '0') {
            alert("Amount is required!");
        }
    })
});