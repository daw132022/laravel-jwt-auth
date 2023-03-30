import { Component, NgModule, OnInit } from '@angular/core';
import { PeticionService } from '../peticion.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';


@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.css']
})

export class CreateComponent implements OnInit {

  form!: FormGroup;
  selectedImage: any;

  /*------------------------------------------
  --------------------------------------------
  Created constructor
  --------------------------------------------
  --------------------------------------------*/
  constructor(
    public peticionService: PeticionService,
    private router: Router,
    private fb: FormBuilder
  ) { }

  /**
   * Write code on Method
   *
   * @return response()
   */
  ngOnInit(): void {
    this.form = this.fb.group({
      titulo: new FormControl('', [Validators.required]),
      descripcion: new FormControl('', Validators.required),
      destinatario: new FormControl('', [Validators.required]),
      categoria_id: new FormControl('', Validators.required),
      firmantes: new FormControl('', Validators.required),
      image: new FormControl('', [Validators.required]),

    });
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  get f(){
    return this.form.controls;
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  submit(form:any){
    const formData = new FormData();
    formData.append('image', this.selectedImage);
    formData.append('titulo', this.form.value.titulo);
    formData.append('descripcion', this.form.value.descripcion);
    formData.append('firmantes', this.form.value.firmantes);
    formData.append('categoria_id', this.form.value.categoria_id);
    formData.append('destinatario', this.form.value.destinatario);

    this.peticionService.create(formData).subscribe(() => {
         console.log('Peticion created successfully!');
         this.router.navigateByUrl('peticion/index');
    })
  }

  onSelectImage(event: any) {
    this.selectedImage = event.target.files[0];
  }

}
