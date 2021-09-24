<?php

interface Downloader
{
    public function download($url);
}

class SimpleDownloader implements Downloader
{
    public function download($url)
    {
        echo "Downloading file from $url\n";
        sleep(2);
        echo "Your Downloaded file is successfully saved.\n";
        return "Result From $url";
    }
}

class DownloaderProxy implements Downloader
{
    private $downloader;

    public function __construct(Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    private $cache = [];

    public function download($url)
    {
        if (!isset($this->cache[$url])) {
            echo "Not in proxy cache\n";
            $result = $this->downloader->download($url);
            $this->cache[$url] = $result;
        } else {
            echo "Download Result From Proxy Cache\n";
        }

        return $this->cache[$url];
    }
}

class Machine
{
    private $downloader;

    public function __construct(Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    public function downloadFile($url)
    {
        $this->downloader->download($url);
    }
}

function client_code() {
    $downloader = new DownloaderProxy(new SimpleDownloader());

    $machine1 = new Machine($downloader);
    $machine2 = new Machine($downloader);

    $machine1->downloadFile("www.example.com");
    $machine2->downloadFile("www.example.com");
}

client_code();
