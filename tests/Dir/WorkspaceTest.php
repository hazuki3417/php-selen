<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2023 hazuki3417 all rights reserved.
 */

namespace Tests\Selen\Dir;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Selen\Dir\Workspace;

/**
 * @coversDefaultClass \Selen\Dir\Workspace
 * * *
 * @see \Selen\Dir\Workspace
 *
 * @internal
 */
class WorkspaceTest extends TestCase
{
    public function dataProviderConstruct()
    {
        return [
            'validPattern: 001' => [
                'expected' => Workspace::class,
                'input'    => '/tmp/phpunit/example',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderConstruct
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testConstruct($expected, $input)
    {
        $this->assertInstanceOf($expected, new Workspace($input));
    }

    public function dataProviderGetPath()
    {
        return [
            'validPattern: 001' => [
                'expected' => '/tmp/phpunit/example',
                'input'    => '/tmp/phpunit/example',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetPath
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testGetPath($expected, $input)
    {
        $instance = new Workspace($input);
        $this->assertSame($expected, $instance->getPath());
    }

    public function dataProviderCreate()
    {
        return [
            'validPattern: 001' => [
                'input' => '/tmp/phpunit/workspace1',
            ],
            'validPattern: 002' => [
                'input' => '/tmp/phpunit/workspace2/images',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCreate
     *
     * @param mixed $input
     */
    public function testCreate($input)
    {
        $this->assertDirectoryDoesNotExist($input);

        $instance = new Workspace($input);
        $instance->create();

        $this->assertDirectoryExists($input);
    }

    public function dataProviderCreateException()
    {
        return [
            'invalidPattern: 001' => [
                'expected' => RuntimeException::class,
                'input'    => '/tmp/phpunit/create-exception',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderCreateException
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testCreateException($expected, $input)
    {
        \mkdir($input, 0777, true);
        $this->assertDirectoryExists($input);
        $this->expectException($expected);

        $instance = new Workspace($input);
        $instance->create();
    }

    public function dataProviderRemove()
    {
        $pattern1 = '/tmp/phpunit/remove-pattern1';
        $pattern2 = '/tmp/phpunit/remove-pattern2';
        $pattern3 = '/tmp/phpunit/remove-pattern3';

        return [
            'validPattern: not exist dir' => [
                'callback' => function () {},
                'input'    => $pattern1,
            ],
            'validPattern: empty dir' => [
                'callback' => function () {},
                'input'    => $pattern2,
            ],
            'validPattern: not empty dir' => [
                'callback' => function () use ($pattern3) {
                    // ファイルが消されることを確認するためにダミーファイルを作成
                    touch(\sprintf('%s/%s', $pattern3, \uniqid()));
                    touch(\sprintf('%s/%s', $pattern3, \uniqid()));
                    touch(\sprintf('%s/%s', $pattern3, \uniqid()));

                    // ファイルを持つディレクトリが消されることを確認するためにダミーファイル・ディレクトリを作成
                    $pattern3NestDir = \sprintf('%s/%s', $pattern3, \uniqid());
                    mkdir($pattern3NestDir, 0777, true);
                    touch(\sprintf('%s/%s', $pattern3NestDir, \uniqid()));
                    touch(\sprintf('%s/%s', $pattern3NestDir, \uniqid()));
                    touch(\sprintf('%s/%s', $pattern3NestDir, \uniqid()));
                },
                'input' => $pattern3,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderRemove
     *
     * @param callable $callback
     * @param mixed $input
     */
    public function testRemove($callback, $input)
    {
        $this->assertDirectoryDoesNotExist($input);

        $instance = new Workspace($input);

        $instance->create();
        $this->assertDirectoryExists($input);

        $callback();

        $instance->remove();
        $this->assertDirectoryDoesNotExist($input);
    }

    public function dataProviderDestruct()
    {
        return [
            'validPattern: 001' => [
                'input' => '/tmp/phpunit/workspace1',
            ],
            'validPattern: 002' => [
                'input' => '/tmp/phpunit/workspace2/images',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderDestruct
     *
     * @param mixed $input
     */
    public function testDestruct($input)
    {
        $this->assertDirectoryDoesNotExist($input);

        $instance = new Workspace($input);
        $instance->create();

        $this->assertDirectoryExists($input);

        unset($instance);

        $this->assertDirectoryDoesNotExist($input);
    }
}
