<?php
namespace SimpleTest;

class TestRunner
{
    private $countCaseFailure = 0;
    private $countCaseSuccess = 0;
    private $countAssertFailure = 0;
    private $countAssertSuccess = 0;
    private $currentTestName = '';

    public function succeed()
    {
        $this->countAssertSuccess++;
    }

    public function fail($message)
    {
        $this->countAssertFailure++;
        fprintf(STDERR, "FAIL: [%s] %s\n", $this->currentTestName, $message);
    }

    public function runeTestMethod($testCase, $classShortName, $method)
    {
        $this->currentTestName = "$classShortName::$method";

        $lastAssertFailure = $this->countAssertFailure;
        $lastAssertSuccess = $this->countAssertSuccess;
        $testCase->$method();
        if ($this->countAssertFailure === $lastAssertFailure && $this->countAssertSuccess === $lastAssertSuccess) {
            $this->fail('no assert');
        }
    }

    public function runTestCase($testCase, $classShortName)
    {
        $testCase::$testRunner = $this;
        $this->currentTestName = $classShortName;

        $lastAssertFailure = $this->countAssertFailure;
        $lastAssertSuccess = $this->countAssertSuccess;
        $methods = get_class_methods($testCase);
        $countTestMethods = 0;
        foreach ($methods as $method) {
            if (strpos($method, 'test') === 0) {
                $this->runeTestMethod($testCase, $classShortName, $method);
                $countTestMethods++;
            }
        }
        if ($this->countAssertFailure === $lastAssertFailure && $this->countAssertSuccess === $lastAssertSuccess) {
            $this->fail('no assert');
        }

        if ($this->countAssertFailure !== $lastAssertFailure) {
            fprintf(STDERR, "FAILED: %s\n", $this->currentTestName);
            $this->countCaseFailure++;
        } else {
            fprintf(STDOUT, "OK: %s (%d asserts in %d methods)\n", $classShortName, $this->countAssertSuccess - $lastAssertSuccess, $countTestMethods);
            $this->countCaseSuccess++;
        }
    }

    public function run($namespace, $dir)
    {
        $files = glob( $dir . '/Test*.php');
        foreach ($files as $file) {
            $classShortName = basename($file, '.php');
            $classFullName = "$namespace\\$classShortName";
            $testCase = new $classFullName();
            $this->runTestCase($testCase, $classShortName);
        }
        if ($this->countCaseSuccess !== 0 || $this->countCaseFailure !== 0) {
            fprintf(STDOUT, "Success: %d cases (%d asserts)\n", $this->countCaseSuccess, $this->countAssertSuccess);
            if ($this->countCaseFailure !== 0) {
                fprintf(STDOUT, " Failure: %d cases (%d asserts)\n", $this->countCaseFailure, $this->countAssertFailure);
            }
        } else {
            fprintf(STDERR, "No tests executed\n");
        }
        return $this->countCaseSuccess !== 0 && $this->countCaseFailure === 0;
    }
}
