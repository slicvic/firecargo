<div class="alert alert-danger">
    <h4><i class="fa fa-times-circle"></i> Oops! Some error(s) occurred:</h4>
    <ul>
        <?php
            if (is_string($message))
            {
                echo '<li>' . $message . '</li>';
            }
            elseif (is_array($message))
            {
                foreach($message as $error)
                {
                    echo '<li>' . $error . '</li>';
                }
            }
            elseif ($message instanceof \Illuminate\Validation\Validator)
            {
                foreach ($message->messages()->getMessages() as $errors)
                {
                    foreach ($errors as $error)
                    {
                        echo '<li>' . $error . '</li>';
                    }
                }
            }
        ?>
    </ul>
</div>
