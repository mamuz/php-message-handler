<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Marco Muths
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace MsgBridgeTest;

class MessageBridgeTest extends \PHPUnit_Framework_TestCase
{
    public function testTriggerMessageWithoutDispatcher()
    {
        $this->assertFalse(triggerMessage('Foo'));
    }

    public function testBindDispatcherUnlocked()
    {
        $dispatcher = function ($name, $argv, $emitter) {
        };
        $dispatcher2 = function ($name, $argv, $emitter) {
        };

        $this->assertNull(setMessageDispatcher($dispatcher, false));
        $this->assertSame($dispatcher, setMessageDispatcher($dispatcher2, false));
    }

    public function testBindDispatcherLocked()
    {
        $dispatcher = function ($name, $argv, $emitter) {
            return array($name, $argv, $emitter);
        };

        setMessageDispatcher($dispatcher);
        $this->setExpectedException('RuntimeException');
        setMessageDispatcher($dispatcher);
    }

    public function testTriggerMessage()
    {
        $name = 'foo';
        $argv = array('foo' => 'bar');
        $emitter = $this;
        $result = triggerMessage($name, $argv, $emitter);

        $this->assertSame(array($name, $argv, $emitter), $result);
    }
}