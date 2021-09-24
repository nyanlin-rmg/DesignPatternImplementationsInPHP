<?php

interface Button
{
    public function click();
    public function mouseOver();
}

class WindowButton implements Button
{
    public function click()
    {
        echo "Click On Window Button\n";
    }

    public function mouseOver()
    {
        echo "Mouse Over Window Button\n";
    }
}

class LinuxButton implements Button
{
    public function click()
    {
        echo "Click On Linux Button\n";
    }

    public function mouseOver()
    {
        echo "Mouse Over Linux Button\n";
    }
}

interface CheckBox
{
    public function checked();
    public function unchecked();
}

class WindowCheckBox implements CheckBox
{
    public function checked()
    {
        echo "Checked Window Check Box\n";
    }

    public function unchecked()
    {
        echo "Unchecked Window Check Box\n";
    }
}

class LinuxCheckBox implements CheckBox
{
    public function checked()
    {
        echo "Checked Linux Check Box\n";
    }

    public function unchecked()
    {
        echo "Unchecked Linux Check Box\n";
    }
}

//Button And Check Box Are Families Of Related Product

interface GUIFactory
{
    public function button();
    public function checkbox();
}

class WindowGUIFactory implements GUIFactory
{
    public function button()
    {
        return new WindowButton();
    }

    public function checkbox()
    {
        return new WindowCheckBox();
    }
}

class LinuxGUIFactory implements GUIFactory
{
    public function button()
    {
        return new LinuxButton();
    }

    public function checkbox()
    {
        return new LinuxCheckBox();
    }
}

function client_code() {
    $linux = new LinuxGUIFactory();
    $linux->button()->click();
    $linux->checkbox()->checked();
}

client_code();
