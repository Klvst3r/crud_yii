<?php

namespace app\controllers;

use app\models\Libro;
use app\models\LibroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\controllers\yii;

//Clase para crar una referencia del archivo que se va a adjuntar a la carpeta uploads
use yii\web\UploadedFile;

/**
 * LibroController implements the CRUD actions for Libro model.
 */
class LibroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Libro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LibroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libro model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Libro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Libro();

        // Llamamos a subirFoto y verificamos si devuelve una respuesta (como redirect)
        /*
            Al enviar el formulario, se llama a subirFoto().
            Si el modelo se guarda exitosamente, redirige automáticamente a index.
            Si no se guarda (por ejemplo, error de validación), se muestra de nuevo el formulario.
        */
        $resultado = $this->subirFoto($model);

        // Si se retorna un resultado (como redirect), lo devolvemos
        if ($resultado !== null) {
            return $resultado;
        }

        // Si no hubo envío de formulario (GET), se muestra el formulario
        return $this->render('create', [
            'model' => $model,
        ]);
    }




    /**
     * Updates an existing Libro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        // Guarda temporalmente la imagen anterior antes de que sea sobreescrita
        $imagenAnterior = $model->imagen;
    
        // Si se está haciendo POST
        if ($this->request->isPost) {
            // Subimos la nueva foto (si la hay) y guardamos
            $this->subirFoto($model);
    
            // Si hay imagen anterior y es distinta a la nueva, eliminamos la anterior
            if ($imagenAnterior && $imagenAnterior !== $model->imagen && file_exists($imagenAnterior)) {
                unlink($imagenAnterior);
            }
    
            // Ya redirige dentro de subirFoto si todo fue bien
            return; // Importante para no volver a renderizar la vista
        }
    
        // Si no es POST, simplemente muestra el formulario de edición
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    

    

    /**
     * Deletes an existing Libro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //Primero lo recuperado lo alamacenara en el modelo
        //$this->findModel($id);
        $model = $this->findModel($id);

        //Posterior a ello vamos a preguntar si tiene el dato imagen y si ese dato existe en lo que es la ruta de lo que es el archivo
        if(file_exists($model->imagen) ){

            //Hacemos una isbtruccion onlink y que permitira tener ese borado
            //Recordando que $model tiene todos los datos, rutas
            unlink($model->imagen);


        }

        //Con esto la imagen se va a borra si encuentra en la carpeta de uploas
            // y una vez que se bore el archivo lo que se hace es borra el registro con la siguiente instrucción
            // Asi no solo se botrrara en la Bd sino que se va a borrar fisicamente con el siguiente comando
            $model->delete();

        
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Libro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Libro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libro::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function subirFoto(Libro $model){

      /*
      Validamos los datos que esten llgenaod y despues hacemos un guardado, permitiendo generar el archivo dentro de la
      Carpeta uploads con el dato del archivo, ya que en le modelo archivo, 
      - Iniciamos con la carpeta 
      - Integramos el tiempo,
      - Nombe del archivo desde su nombre baseName el nombre del archivo original
      - punto y la extensión igual del model pero del archivo que nos esta dando
      
      Con esto estamos reescribiendo el nombre del archivo para evitar duplicaciones.

     Al guardar tenemos el parametro false para que no genere error.
      */

            if ($model->load($this->request->post()) ) {

                $model->archivo = UploadedFile::getInstance($model, 'archivo');

                //Validamos existencia del archivo
                if($model->validate()){
                    //Validacion de entrada
                    if($model->archivo){
                        //si existe un archivo adjunto, borra ese archivo  y despues adjuntarlo a lo que es carpeta.


                        //Pasamos la ruta del archivo y su nombre
                        $rutaArchivo = 'uploads/'.time()."_".$model->archivo->baseName.".".$model->archivo->extension;

                        //Validamos si el archivo esta adjunto, ya se logro guardar
                        if($model->archivo->saveAs($rutaArchivo)){

                            //Actualizamos la ruta del archivo
                            $model->imagen=$rutaArchivo;

                            
                        }

                    }
                }


                //Ahora vamos a asaber si se guardo
                if($model->save(false) ){
                    //se redirecciona si hubo un guardado, unicamente a index.
                    //Ya que index es la lista donde se muestran los libros
                    return $this->redirect(['index']);

                }

                
            }
            //return $this->redirect(['view', 'id' => $model->id]);
            //En su lugar retornamos No hacer nada si no hay POST o falló el guardado
            return null;
       
    }

}
