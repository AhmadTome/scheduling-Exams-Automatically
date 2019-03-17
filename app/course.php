<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class course extends Model
{
   protected $table = 'course';

   public function getMajorName($id){

       $major =  major::where('id',$id)->get();
       return $major[0]->name;
   }
   public function test(){
       return 1;
   }
}
