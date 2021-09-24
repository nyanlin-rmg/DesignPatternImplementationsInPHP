<?php

interface Logger
{
    public function log($message);
}

class BasicLogger implements Logger
{
    public function log($message)
    {
        return "$message";
    }
}

class HTMLDecorator implements Logger
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }


    public function log($message)
    {
        return "<html>\n \t<body>\n \t \t<p>\n\t\t\t" . $this->logger->log($message) . "\n\t\t</p>\n\t</body>\n</html>";
    }
}

class TimeDecorator implements Logger
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function log($message)
    {
        return $this->logger->log($message) . " (Date And Time: " . date('l jS \of F Y h:i:s A') . ")";
    }
}

function client_code() {
    $logger = new HTMLDecorator(new TimeDecorator(new BasicLogger()));
    echo $logger->log("Decorator Testing Log Message");
}

client_code();
