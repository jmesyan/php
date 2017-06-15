<?php

    /**
     * Encapsulates a closure.
     */
    final class Delegate
    {
        private $_Closure;

        /**
         * Standard ctor with a callable as argument.
         * @param callable $closure
         */
        public function __construct($closure)
        {
            $this->_Closure = $closure;
        }

        /**
         * Allows to call the delegate object directly.
         * @param list ...$args variable number of arguments.
         * @return mixed
         */
        public function __invoke(...$args)
        {
            return call_user_func_array($this->_Closure, $args);
        }
    }

    /**
     * Defines a type for event arguments.
     */
    class EventArgs
    {
        protected $_Sender;

        /**
         * Standard ctor.
         * @param mixed $sender [optional]
         */
        public function __construct($sender = NULL)
        {
            $this->_Sender = $sender;
        }

        /**
         * @property-read
         * @return object -should contain the event emitting object.
         */
        final public function Sender() { return $this->_Sender; }
    }

    /**
     * A basic event type for the delegate.
     */
    class Event
    {
        private $_Receivers = array();

        /**
         * Add a delegate to the event list.
         * @param Delegate $delegate
         * @return Event
         */
        final public function Add(Delegate $delegate):Event
        {
            $this->_Receivers[] = $delegate;
            return $this;
        }

        /**
         * Fires the event.
         * @param EventArgs $e
         */
        final public function Trigger(EventArgs $e)
        {
            print_r($e);
            foreach($this->_Receivers as $delegate)
                $delegate($e);
        }
    }

    // declare anonymous function as delegate
    $myDelegate =
        new Delegate
        (
            function (EventArgs $e)
            {
                echo 'anonymous function<br>';
            }
        );

    // declare event, assign the delegate, trigger event
    $myEvent = new Event();
    $myEvent->Add($myDelegate);

    /**
     * Defines a simple type that can handle events
     */
    class demoEventHandler
    {
        /**
         * Handles incomming events.
         * Note: needs declared as public!
         * @param EventArgs $e
         */
        public function onEvent(EventArgs $e)
        {
            echo 'class event handler<br>';
        }
    }

    $controller = new demoEventHandler();
    $myEvent->Add(new Delegate([$controller, 'onEvent']));
    $myEvent->Trigger(new EventArgs($myEvent));
?>