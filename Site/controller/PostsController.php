<?php
class PostsController extends Controller{

    function index(){
        $perPage = 1;
        $this->loadModel('Post');
        $condition = array('online' => 1,'type'=>'post');
        $d['posts'] = $this->Post->find(array(
            'conditions' => $condition,
            'limit' => ($perPage*($this->request->page-1)).','.$perPage
        ));
        $d['total'] = $this->Post->findCount($condition);
        $d['page'] = ceil($d['toatal'] / $perPage);
        $this->set($d);
    }

    function view($id, $slug){
        $this->loadModel('Post');
        $d['post'] = $this->Post->findFirst(array(
            'fields'     => 'id,slug,content,name',
            'conditions' => array('online' => 1,'id'=>$id,'type'=>'post')
        ));
        if(empty($d['post'])){
            $this->e404('Page introuvable');
        }
        if($slug != $d['post']->slug){
            $this->redirect("posts/view/id:$id/slug:".$d['post']->slug,301);
        }
        $this->set($d);
    }

    /**
    * ADMIN 
    */
    function admin_index(){
        $perPage = 10;
        $this->loadModel('Post');
        $condition = array('type'=>'post');
        $d['posts'] = $this->Post->find(array(
            'fields'     => 'id,name,online',
            'conditions' => $condition,
            'limit'      => ($perPage*($this->request->page-1)).','.$perPage
        ));
        $d['total'] = $this->Post->findCount($condition);
        $d['page'] = ceil($d['toatal'] / $perPage);
        $this->set($d);
    }

    /** 
    * Permet d'éditer un article 
    **/
    function admin_edit($id){
        $this->loadModel('Post');
        $this->request->data = $this->Post->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
    }

    /** 
    * Permet de supprimer un article 
    **/
    function admin_delete($id){
        $this->loadModel('Post');
        $this->Post->delete($id);
        $this->Session->setFlash('Le contenu a bien été supprimé');
        $this->redirect('admin/posts/index');
    }
    

}
