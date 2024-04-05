<!DOCTYPE html>
<html>
<head>
    <title>File Upload Form</title>
</head>
<body>
    <h2>Requests</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <table>
    <tr><td>
    Name: </td><td><input type="text" name="name" required=""></td></tr>
    <tr><td>
    Designation: </td><td><select name="desig" required="">
        <option value="">---Select---</option>
        <option value="Lecturer (Temporary)">Lecturer (Temporary)</option>
        <option value="Lecturer (Probationary)">Lecturer (Probationary)</option>
        <option value="Lecturer (Unconfirmed)">Lecturer (Unconfirmed)</option>
        <option value="Senior Lecturer Grade i">Senior Lecturer Grade i</option>
        <option value="Senior Lecturer Grade ii">Senior Lecturer Grade ii</option>
    </select></td></tr>
    <tr><td>
    E-mail address: </td><td><input type="email" name="email" required=""></td></tr>
    <tr><td>
    Department: </td><td><input type="text" name="dept" required=""></td></tr>
    <tr><td>
    HOD email: </td><td><input type="email" name="hodemail" required=""></td></tr>
    <tr><td>
    Attachment: </td><td><input type="file" name="file"></td></tr>
    <tr><td><button type="submit" name="submit">Upload</button></td></tr>
    </table>
    </form>
</body>
</html>