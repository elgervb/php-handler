<?php
namespace handler;

/**
 * Collections of handlers
 *
 * @author eaboxt
 *        
 */
class Handlers
{

    private static $INSTANCE;

    /**
     * Handlers for controller responses
     *
     * @var \ArrayObject
     */
    private $handlers;

    /**
     * Constructor
     *
     * @throws Exception when singleton is not respected
     */
    public function __construct()
    {
        if (self::$INSTANCE !== null) {
            throw new \Exception("This is a singleton, use get() to return the instance!");
        }
        $this->handlers = new \ArrayObject();
    }

    /**
     * Add a new handler to handle controller responses
     *
     * @param IHander $handler            
     *
     * @return Context $this for chaining
     */
    public function add(IHander $handler)
    {
        $this->handlers->append($handler);
        
        return $this;
    }

    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new Handlers();
        }
        
        return self::$instance;
    }

    /**
     * Returns a handler for an object
     *
     * @param mixed $for            
     *
     * @return \handler\IHandler | NULL
     */
    public function getHandler($for)
    {
        /* @var $handler \handler\IHandler */
        foreach ($this->handlers as $handler) {
            
            if ($handler->accept($for)) {
                return $handler;
            }
        }
        
        return null;
    }
}

