<?php
class Classes extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey='classid';
    protected $foreignKey='classmodule';
    protected $table = 'classes';
    public $timestamps = false;
    /**
     * Whitelisted model properties for mass assignment.
     *
     * @var array
     */
    protected $fillable = array('classlecturer', 'classstudents', 'classmodules', 'classlimit', 'classtimes');
    /**
     * 
     */
    public function module()
    {
        return $this->belongsTo('Module', 'classmodule');
    }

    public function fromLecturer($lecturer)
    {
        return $this->where('lecturerid', $lecturer);
    }
}