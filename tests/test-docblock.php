<?php
namespace Johnbillion\DocsStandards\Tests;

class Docblock extends \PHPUnit_Framework_TestCase {

	/**
	 * Test that missing docblocks fail the test.
	 */
	public function testMissingDocblockFails() {

		require_once __DIR__ . '/includes/docblock-missing.php';

		$this->doFailTest(
			__NAMESPACE__ . '\docblock_missing',
			'testDocblockIsPresent',
			'Missing docblock passes the test',
			\Johnbillion\DocsStandards\TestCase::$docblock_missing
		);

	}

	/**
	 * Test that non-missing docblocks pass the test.
	 */
	public function testNonMissingDocblockPasses() {

		require_once __DIR__ . '/includes/docblock-missing.php';

		$this->doPassTest(
			__NAMESPACE__ . '\docblock_not_missing',
			'testDocblockIsPresent',
			'Non-missing docblock fails the test'
		);

	}

	/**
	 * Test that empty docblocks fail the test.
	 */
	public function testEmptyDocblockFails() {

		require_once __DIR__ . '/includes/docblock-empty.php';

		$this->doFailTest(
			__NAMESPACE__ . '\docblock_empty',
			'testDocblockHasDescription',
			'Empty docblock passes the test',
			\Johnbillion\DocsStandards\TestCase::$docblock_desc_empty
		);

	}

	/**
	 * Test that non-empty docblocks pass the test.
	 */
	public function testNonEmptyDocblockPasses() {

		require_once __DIR__ . '/includes/docblock-empty.php';

		$this->doPassTest(
			__NAMESPACE__ . '\docblock_not_empty',
			'testDocblockHasDescription',
			'Non-empty docblock fails the test'
		);

	}

	/**
	 * Perform a test that is expected to fail.
	 *
	 * @param  string|array $target_function The function name, or array of class name and method name.
	 * @param  string       $test_method     The TestCase method to perform the test.
	 * @param  string       $fail_message    The failure message to use if the test unexpectedly passes.
	 * @param  string       $expected_error  The expected error message.
	 * @return null
	 */
	protected function doFailTest( $target_function, $test_method, $fail_message, $expected_error ) {

		require_once __DIR__ . '/includes/stub-testcase.php';

		$case = new Stub_TestCase;

		try {

			call_user_func( array( $case, $test_method ), $target_function );

		} catch ( \PHPUnit_Framework_ExpectationFailedException $e ) {

			$expected = sprintf(
				$expected_error,
				$target_function . '()'
			);
			$this->assertContains( $expected, $e->getMessage() );

			return;

		} catch( \Exception $e ) {

			$this->fail( sprintf(
				"Unexpected exception '%s' with message '%s'",
				get_class( $e ),
				$e->getMessage()
			) );

		}

		$this->fail( $fail_message );

	}

	/**
	 * Perform a test that is expected to pass.
	 *
	 * @param  string|array $target_function The function name, or array of class name and method name.
	 * @param  string       $test_method     The TestCase method to perform the test.
	 * @param  string       $fail_message    The failure message to use if the test unexpectedly fails.
	 * @return null
	 */
	protected function doPassTest( $target_function, $test_method, $fail_message ) {

		require_once __DIR__ . '/includes/stub-testcase.php';

		$case = new Stub_TestCase;

		try {

			call_user_func( array( $case, $test_method ), $target_function );

		} catch ( \PHPUnit_Framework_ExpectationFailedException $e ) {

			$this->fail( sprintf(
				"%s: Unexpected failure with message '%s'",
				$fail_message,
				$e->getMessage()
			) );

		} catch( \Exception $e ) {

			$this->fail( sprintf(
				"Unexpected exception '%s' with message '%s'",
				get_class( $e ),
				$e->getMessage()
			) );

		}

	}

}
