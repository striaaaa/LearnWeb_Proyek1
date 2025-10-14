<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
// helpers/db_helper.php
function runQuery($sql, $params = [], $types = '')
{
    // $conn = getMysqliConnection();
    // $stmt = $conn->prepare($sql);

    // if (!$stmt) {
    //     throw new Exception("Prepare failed: " . $conn->error);
    // }

    // if (!empty($params)) {
    //     if ($types === '') {
    //         //  tipe (i=int, d=double, s=string, b=blob)
    //         $types = '';
    //         foreach ($params as $param) {
    //             $types .= is_int($param) ? 'i' : (is_float($param) ? 'd' : 's');
    //         }
    //     }
    //     $stmt->bind_param($types, ...$params);
    // }

    // $stmt->execute();
    // $result = $stmt->get_result();

    // if ($result) {
    //     $data = $result->fetch_all(MYSQLI_ASSOC);
    // } else {
    //     $data = [];
    // }

    // $stmt->close();
    // $conn->close();

    // return $data; 
    $conn = getMysqliConnection();

    try {

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
 
        if (!empty($params)) {
            if ($types === '') {
                $types = '';
                foreach ($params as $param) {
                    $types .= is_int($param) ? 'i' : (is_float($param) ? 'd' : 's');
                }
            }
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        } 


        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
 
        $queryType = strtoupper(strtok(trim($sql), ' '));
        $result = null;

        switch ($queryType) {
            case 'SELECT':
                $res = mysqli_stmt_get_result($stmt);
                $result = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
                break;

            case 'INSERT':
                $result = [
                    'insert_id' => mysqli_insert_id($conn),
                    'affected_rows' => mysqli_stmt_affected_rows($stmt)
                ];
                break;

            case 'UPDATE':
            case 'DELETE':
                $result = [
                    'affected_rows' => mysqli_stmt_affected_rows($stmt)
                ];
                break;

            default:
                $result = ['message' => 'Query executed successfully'];
        }


        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $result ;

    } catch (Exception $e) {

        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($conn)) mysqli_close($conn);

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }

}
