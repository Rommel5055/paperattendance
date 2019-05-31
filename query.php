<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/local/paperattendance/locallib.php');
global $DB, $CFG;
//Deleted 3 in role ID, so it just takes teachers

require_login();
if (isguestuser()) {
    print_error(get_string('notallowedprint', 'local_paperattendance'));
    die();
}

$param = explode("," ,$CFG->paperattendance_enrolmethod);
var_dump($param);
list ( $sqlin, $param1 ) = $DB->get_in_or_equal ( $param);
$param2 = ["profesoreditor", "profesornoeditor"];
$params = array_merge($param1, $param2);
var_dump($params);

$query = "SELECT 
                CONCAT(c.id,'-',u.id) as superid,
                c.id,
				c.fullname,
				cat.name,
				u.id as teacherid,
				CONCAT( u.firstname, ' ', u.lastname) as teacher,
                e.enrol, 
                r.shortname as role
				FROM {user} AS u
                INNER JOIN {user_enrolments} ue ON (ue.userid = u.id)
				INNER JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol $sqlin)
				INNER JOIN {role_assignments} ra ON (ra.userid = u.id)
				INNER JOIN {context} ct ON (ct.id = ra.contextid)
				INNER JOIN {course} c ON (c.id = ct.instanceid)
				INNER JOIN {role} r ON (r.id = ra.roleid AND r.shortname = ?)
				INNER JOIN {course_categories} as cat ON (cat.id = c.category)
				WHERE c.idnumber > 0
				GROUP BY c.id, CONCAT(c.id,'-',u.id)
				ORDER BY c.fullname";
$results = $DB->get_records_sql($query, $params);

echo "<table border = 1>
        <tr>
        <th>id</th>
        <th>Course name</th>
        <th>cat name</th>
        <th>editingteacher id</th>
        <th>editingteacher</th>
        <th>enrol</th>
        <th>role</th>
        </tr>
        ";
foreach ($results as $row){
    echo "<tr>";
    echo "<td>". $row->id."</td>";
    echo "<td>". $row->fullname."</td>";
    echo "<td>". $row->name."</td>";
    echo "<td>". $row->teacherid."</td>";
    echo "<td>". $row->teacher."</td>";
    echo "<td>". $row->enrol."</td>";
    echo "<td>". $row->role."</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo"###################################################################################################<br>";
echo"####################################Profesor by Database###########################################<br>";
echo"###################################################################################################<br>";

$param = ["database"];
var_dump($param);
list ( $sqlin, $param1 ) = $DB->get_in_or_equal ( $param);
$param2 = ["profesoreditor", "profesornoeditor"];
$params = array_merge($param1, $param2);
var_dump($params);
$query = "SELECT
                CONCAT(c.id,'-',u.id) as superid,
                c.id,
				c.fullname,
				cat.name,
				u.id as teacherid,
				CONCAT( u.firstname, ' ', u.lastname) as teacher,
                e.enrol,
                r.shortname as role
				FROM {user} AS u
                INNER JOIN {user_enrolments} ue ON (ue.userid = u.id)
				INNER JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol $sqlin)
				INNER JOIN {role_assignments} ra ON (ra.userid = u.id)
				INNER JOIN {context} ct ON (ct.id = ra.contextid)
				INNER JOIN {course} c ON (c.id = ct.instanceid)
				INNER JOIN {role} r ON (r.id = ra.roleid AND r.shortname = ?)
				INNER JOIN {course_categories} as cat ON (cat.id = c.category)
				WHERE c.idnumber > 0
				GROUP BY c.id, CONCAT(c.id,'-',u.id)
				ORDER BY c.fullname";
$results = $DB->get_records_sql($query, $params);

echo "<table border = 1>
        <tr>
        <th>id</th>
        <th>Course name</th>
        <th>cat name</th>
        <th>editingteacher id</th>
        <th>editingteacher</th>
        <th>enrol</th>
        <th>role</th>
        </tr>
        ";
foreach ($results as $row){
    echo "<tr>";
    echo "<td>". $row->id."</td>";
    echo "<td>". $row->fullname."</td>";
    echo "<td>". $row->name."</td>";
    echo "<td>". $row->teacherid."</td>";
    echo "<td>". $row->teacher."</td>";
    echo "<td>". $row->enrol."</td>";
    echo "<td>". $row->role."</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";

echo"################################################################################################<br>";
echo"###############################All enrolment####################################################<br>";
echo"################################################################################################<br>";

$param = ["profesoreditor", "profesornoeditor"];
list ( $sqlin, $param1 ) = $DB->get_in_or_equal ( $param);
var_dump($param1);
$query = "SELECT
                CONCAT(c.id,'-',u.id) as superid,
                c.id,
				c.fullname,
				cat.name,
				u.id as teacherid,
				CONCAT( u.firstname, ' ', u.lastname) as teacher,
                e.enrol,
                r.shortname as role
				FROM {user} AS u
                INNER JOIN {user_enrolments} ue ON (ue.userid = u.id)
				INNER JOIN {enrol} e ON (e.id = ue.enrolid)
				INNER JOIN {role_assignments} ra ON (ra.userid = u.id)
				INNER JOIN {context} ct ON (ct.id = ra.contextid)
				INNER JOIN {course} c ON (c.id = ct.instanceid)
				INNER JOIN {role} r ON (r.id = ra.roleid AND r.shortname $sqlin)
				INNER JOIN {course_categories} as cat ON (cat.id = c.category)
				WHERE c.idnumber > 0
				GROUP BY c.id, CONCAT(c.id,'-',u.id)
				ORDER BY c.fullname";
$results = $DB->get_records_sql($query, $param1);

echo "<table border = 1>
        <tr>
        <th>id</th>
        <th>Course name</th>
        <th>cat name</th>
        <th>editingteacher id</th>
        <th>editingteacher</th>
        <th>enrol</th>
        <th>role</th>
        </tr>
        ";
foreach ($results as $row){
    echo "<tr>";
    echo "<td>". $row->id."</td>";
    echo "<td>". $row->fullname."</td>";
    echo "<td>". $row->name."</td>";
    echo "<td>". $row->teacherid."</td>";
    echo "<td>". $row->teacher."</td>";
    echo "<td>". $row->enrol."</td>";
    echo "<td>". $row->role."</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";



echo "Roles<br>";
$query = "SELECT * FROM {role}";
$results = $DB->get_records_sql($query);
echo "<table border = 1>
        <tr>
        <th>id</th>
        <th>name</th>
        <th>shortname</th>
        <th>description</th>
        <th>sortorder</th>
        <th>archetype</th>
        </tr>
        ";
foreach ($results as $row){
    echo "<tr>";
    echo "<td>". $row->id."</td>";
    echo "<td>". $row->name."</td>";
    echo "<td>". $row->shortname."</td>";
    echo "<td>". $row->description."</td>";
    echo "<td>". $row->sortorder."</td>";
    echo "<td>". $row->archetype."</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";


echo"################################################################################################<br>";
echo"###############################Print Search#####################################################<br>";
echo"################################################################################################<br>";
$param = explode("," ,$CFG->paperattendance_enrolmethod);
var_dump($param);
list ( $sqlin, $param1 ) = $DB->get_in_or_equal ( $param);
$param2 = ["profesoreditor"];
$params = array_merge($param1, $param2);
var_dump($params);

$query = "SELECT
                CONCAT(c.id,'-',u.id) as superid,
                c.id,
				c.fullname,
				cat.name,
				u.id as teacherid,
				CONCAT( u.firstname, ' ', u.lastname) as teacher,
                e.enrol,
                r.shortname as role
				FROM {user} AS u
                INNER JOIN {user_enrolments} ue ON (ue.userid = u.id)
				INNER JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol $sqlin)
				INNER JOIN {role_assignments} ra ON (ra.userid = u.id)
				INNER JOIN {context} ct ON (ct.id = ra.contextid)
				INNER JOIN {course} c ON (c.id = ct.instanceid)
				INNER JOIN {role} r ON (r.id = ra.roleid AND r.shortname = ?)
				INNER JOIN {course_categories} as cat ON (cat.id = c.category)
				WHERE c.idnumber > 0
				GROUP BY c.id, CONCAT(c.id,'-',u.id)
				ORDER BY c.fullname";
$results = $DB->get_records_sql($query, $params);

echo "<table border = 1>
        <tr>
        <th>id</th>
        <th>Course name</th>
        <th>cat name</th>
        <th>editingteacher id</th>
        <th>editingteacher</th>
        <th>enrol</th>
        <th>role</th>
        </tr>
        ";
foreach ($results as $row){
    echo "<tr>";
    echo "<td>". $row->id."</td>";
    echo "<td>". $row->fullname."</td>";
    echo "<td>". $row->name."</td>";
    echo "<td>". $row->teacherid."</td>";
    echo "<td>". $row->teacher."</td>";
    echo "<td>". $row->enrol."</td>";
    echo "<td>". $row->role."</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";