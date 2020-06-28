import json

php_code = ''
with open('form-structure.json', 'r', encoding='utf-8') as f:
    data = json.load(f)
    q_info = data['qInfo']
    q_len = len(q_info)
    q_lst = []
    email_content = ''
    for i in range(q_len):
        q_lst.append('question'+str(i+1))

    for i in range(q_len):
        email_content += '''<tr>
<td>{}</td><td>".${}."</td>
</tr>
'''.format(q_info[i]['question'],q_lst[i])
    email_content += '</table>'
    
    php_post = ''
    php_escape = ''
    for q_name in q_lst:
        php_post += '$' + q_name + ' = $_POST[' + q_name + '];\n'
        php_escape += '$' + q_name + ' = mysqli_real_escape_string($connection, $' + q_name + ');\n'

php_head = ''
if data['email'] == True:
    php_head += '''use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../libs/PHPMailer/vendor/autoload.php';
require __DIR__ . '/../../../../sec/email_con.php';
'''
    php_email = "$info='" + email_content + "';\n"
    php_code += php_email


if data['database'] == True:
    php_head += '''require __DIR__ . '/../../../../sec/pass.php';
'''
    php_database = '''$connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!");
'''
    php_database += php_escape
    php_database += '''mysqli_set_charset($connection,"utf8");
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-m-d h:i:sa");
$sql = "INSERT INTO TABLE_NAME
'''

    sql = '''INSERT INTO TABLE_NAME
({column_name}) 
VALUES
({column_data})";
'''.format(column_name=', '.join('`' + x +'`' for x in q_lst), column_data =', '.join('\'$' + x +'\'' for x in q_lst))
    php_database += sql

    php_database += '''mysqli_query($connection, $sql);
    /*		if (mysqli_query($connection, $sql)) {
        echo "提交成功";
        } else {
        echo "Error: " . $sql . "" . mysqli_error($connection);
        }*/
$connection->close(); 
    '''
    php_code += php_database

php_code = '\n'.join(('<?php', php_head, php_code))
print(php_code)

with open('success_temp.php', 'w', encoding='utf-8') as f:
    f.write(php_code)