$(document).ready(function () {
    $('#formsheet').validate({ // initialize the plugin
        errorElement: 'div',
/*      messages: {
            'question5': {
                email: "请输入有效的电子邮箱地址！"
            }
        },
       rules: {
            'question7[]': {
                required: true
            },
            question7_other: {
                required: "#question7_other:checked"
            },
            'question8[]': {
                required: true
            },
            question8_other: {
                required: "#question8_other:checked"
            },
            'question10[]': {
                required: true
            },
			['soci1, soci_choice, soci2']: {
				required:"#探索社会科学:checked"
			},
			['stem1, stem_choice, stem2']: {
				required:"#思考数学与科学:checked"
            },
            ['ling1, ling_choice, ling2']: {
				required:"#探索语言:checked"
            },
            ['huma1, huma2']: {
				required:"#阅读历史，书写记忆:checked"
			}
        }, */
        errorPlacement: function(error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                error.appendTo(element.parent().parent().children().last());
            }
            else {
                error.insertAfter(element);
            }
        }
    });
    $.validator.messages.required = "此问题为必填！";
});