if (window && window.console) {
    console.log("%c Support By UQPAY", "font-size: 40px; color: #4285f4");
}
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
    var supportedMethod = {};
    post("/check/method").done(function (result) {
        if (result.success) {
            supportedMethod = result.data;
        }
    });
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

    const $addressCountry = $('#addressCountry');
    const option = "<option value='{val}'>{label}</option>";
    countries.forEach(function (value) {
        const label = document.cookie.indexOf("locale=zh_CN") > -1 ? value.name_zh_cn : value.name;
        $addressCountry.append(option.replace('{val}',value.code).replace('{label}', label));
    })

    const Credit_Card_Support = {
        VISA: {
            name: 'VISA',
        },
        AMEX: {
            name: 'AMEX',
        },
        JCB: {
            name: 'JCB',
        },
        Master: {
            name: 'Master',
        },
        UnionPay: {
            name: 'UnionPay',
        },
    }
    function matchLuhn(cardNo) {
        if (/^\d+$/g.test(cardNo)) {
            const cardNums = [];
            for (var i = 0; i < cardNo.length; i++) {
                cardNums.push(parseInt(cardNo[i], 10));
            }
            for (var j = cardNums.length - 2; j >= 0; j -= 2) {
                cardNums[j] <<= 1;
                cardNums[j] = parseInt((cardNums[j] / 10 + cardNums[j] % 10), 10);
            }
            var sum = 0;
            for (var k = 0; k < cardNums.length; k++) {
                sum += cardNums[k];
            }
            return sum % 10 === 0;
        }
        return false;
    }
    function checkCardType(value) {
        if (value.startsWith('4')) {
            return Credit_Card_Support.VISA;
        }
        if (value.startsWith('5')) {
            return Credit_Card_Support.Master;
        }
        if (value.startsWith('62')) {
            return Credit_Card_Support.UnionPay;
        }
        if (value.startsWith('34') || value.startsWith('37')) {
            return Credit_Card_Support.AMEX;
        }
        if (value.startsWith('35')) {
            return Credit_Card_Support.JCB;
        }
        return {
            name: 'CreditCard',
            code: 0000,
        }
    }
    function isSupport(cardName) {
        return supportedMethod[cardName];
    }
    const $cardNumValid = $('#cardNumValid');
    const $cardNum = $('#cardNum');
    const $cardType = $('#cardType');
    function showCardType(show, type) {
        if (show) {
            $cardType.attr('src', '/images/method/{type}.jpg'.replace('{type}', type));
        } else {
            $cardType.attr('src', '/images/method/CreditCard.jpg');
        }
    }
    function feedbackCardNum(isValid, message) {
        if (isValid) {
            $cardNum.removeClass('is-invalid');
            $cardNumValid.html('');
        } else {
            $cardNum.addClass('is-invalid');
            $cardNumValid.html(message);
        }
    }
    const cardNoValid = {
        isValid: false,
        method: 0,
    }
    $cardNum.change(function () {
        const value = $(this).val();
        if (matchLuhn(value)) {
            feedbackCardNum(true);
            if (value.length > 3) {
               var cardType = checkCardType(value);
               showCardType(true, cardType.name);
               var methodId = isSupport(cardType.name);
               if (methodId) {
                   feedbackCardNum(true);
                   cardNoValid.isValid = true;
                   cardNoValid.method = methodId;
               } else {
                   cardNoValid.isValid = false;
                   feedbackCardNum(false, document.cookie.indexOf("locale=zh_CN") > -1 ? '不支持的卡类型' : 'Card type is not supported');
               }
            }
        } else {
            cardNoValid.isValid = false;
            feedbackCardNum(false, document.cookie.indexOf("locale=zh_CN") > -1 ? '请输入正确格式的卡号' : 'Please enter the card number in the correct format');
        }
    });
    const Method_Checked_Class = 'checked';
    const Order_State_Enum = {
        Ready: 'Ready',//待支付
        Paying: 'Paying',//支付中
        Success: 'Success',//已付款
        MultiPay: 'MultiPay',//多付款单
        Exception: 'Exception',//异常
        Failed: 'Failed',//付款失败
    };
    const $alertModal = $('#alertModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false,
    });
    $alertModal.$message = $alertModal.find('div.alert-message');
    function alertModal(message, closedCb, openCb) {
        $alertModal.$message.html(message);
        $alertModal.modal('show');
        if (closedCb) {
            $alertModal.on('hidden.bs.modal', closedCb);
        }
        if (openCb) {
            $alertModal.on('shown.bs.modal', closedCb);
        }
    }
    const qrRecord = {};
    const $qrBox = $(".qr-box");
    const $qrImg = $qrBox.find("img.qr-box-qrImg");
    const $creditCardForm = $(".credit-form-box");
    var returnUrl = '';

    function showBox($box) {
        $box.removeAttr('style');
    }

    function hideBox($box) {
        $box.attr("style", "height:0; padding-top: 0");
    }

    var hasCheckError = 0;
    function checkOrderState(orderId) {
        const interval = window.setInterval(function () {
            post('/order/'+orderId)
                .done(function (result) {
                    if (result.success) {
                        if (result.data === Order_State_Enum.Success) {
                            clearInterval(interval);
                            window.location.href = returnUrl;
                        } else if (result.data !== Order_State_Enum.Ready && result.data !== Order_State_Enum.Paying){
                            clearInterval(interval);
                            alertModal("Payment Fail", function closeCb() {
                                window.location.href = returnUrl;
                            });
                        }
                    } else {
                        hasCheckError += 1;
                        if (hasCheckError === 5) {
                            alertModal(result.data, function closeCb() {
                                window.location.href = returnUrl;
                            });
                        }
                    }
                })
                .fail(function () {
                    clearInterval(interval);
                    alert("网络连接错误");
                })
        }, 3000);
    }

    function jumpUrl(jump) {
        if (jump.method === 'post') {
            formPost(jump.targetUrl, jump.params);
        } else {
            window.location.href = jump.jumpUrl;
        }
    }

    $("div[data-method]").click(function () {
        const $this = $(this);
        const type = $this.data('type');
        const method = $this.data('method');
        console.log(type);
        const lastChecked = $("div.pay-method-item.checked");
        if (lastChecked.data('method') !== method) {
            lastChecked.removeClass(Method_Checked_Class);
            $this.addClass(Method_Checked_Class);

            if (type === 'qr') {
                showBox($qrBox);
                post("/pay/qr", {methodId: method})
                    .done(function done(result) {
                        console.log(result);
                        if (result.success) {
                            $qrImg.attr('src', result.data.qrCodeUrl);
                            returnUrl = result.data.returnUrl;
                            checkOrderState(result.data.uqOrderId);
                        }
                    });
            } else {
                hideBox($qrBox);
            }
            if (type === 'creditCard') {
                showBox($creditCardForm);
            } else {
                hideBox($creditCardForm);
            }
            if (type === 'jump') {
                post("/pay/online", {methodId: method})
                    .done(function done(result) {
                        if (result.success) {
                            jumpUrl(result.data);
                        }
                    });
            }
        }
    });

    $('#creditCardForm').submit(function formSub() {
        const formData = {};
        const hasError = {};
        const $form = $(this);
        $.each($form.serializeArray(), function cb() {
            if (this.name !== '_csrf') {
                formData[this.name] = this.value;
                const dataLink = 'div[data-link-field=' + this.name + ']';
                if (!this.value) {
                    $(dataLink).addClass('has-danger');
                    hasError[this.name] = 1;
                } else {
                    $(dataLink).removeClass('has-danger');
                    delete hasError[this.name];
                }
            }
        });
        if (!Object.keys(hasError).length && cardNoValid.isValid) {
            $form.find('button[type=submit]').attr('disable','disable').find('i').addClass('fa-spinner');
            formData.methodId = cardNoValid.method;
            post('/pay/creditCard', formData)
                .done(function (result) {
                    if (result.success) {
                        if (result.data.jumpUrl) {
                            jumpUrl(result.data);
                        } else if (result.data.state === Order_State_Enum.Success) {
                            window.location.href = result.data.returnUrl;
                        } else {
                            alertModal("Payment Fail:" + result.data.state, function closeCb() {
                                window.location.href = result.data.returnUrl;
                            });
                        }
                    } else {
                        alertModal(result.data);
                    }
                })
                .fail(function () {
                    alert("Network Connection Error");
                })
                .always(function () {
                    $form.find('button[type=submit]').removeAttr('disable').find('i').removeClass('fa-spinner');
                })
        }
        return false;
    });
});