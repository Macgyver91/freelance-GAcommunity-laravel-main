<?php
    namespace App\Graphql\Queries;

    class MemberQueries{
        public function all(){
            return \App\Models\Membre::all();
        }

        public function find(array $args){
            return \App\Models\Membre::find($args['id']);
        }
    }


?>