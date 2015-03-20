<div class="alert alert-danger">
    <b><i class="fa fa-times"></i> Oops</b>
    <ul>
        <?php
            if (is_string($message)) {
                echo '<li> ' . $message . '</li>';
            }
            else {

                if (is_array($message)) {
                    foreach($message as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                }
                elseif ($message instanceof Illuminate\Support\MessageBag) {
                    foreach($message->getMessages() as $errors) {
                        foreach($errors as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                    }
                }

            }

        ?>
    </ul>
</div>
