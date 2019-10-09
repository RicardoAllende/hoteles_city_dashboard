class Persona {
    constructor(nombre, edad){
        this.nombre = nombre;
        this.edad = edad;
    }

    saludar(){
        console.log('Hola mi nombre es ${this.nombre} y tengo ${this.edad}')
    }
}

let persona = new Persona('Isay',23);

persona.saludar();