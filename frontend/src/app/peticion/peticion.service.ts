import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import {  Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

import { Peticion } from './peticion';

@Injectable({
  providedIn: 'root'
})
export class PeticionService {

  private apiURL = "http://http://127.0.0.1:8000/api";

  /*------------------------------------------
  --------------------------------------------
  Http Header Options
  --------------------------------------------
  --------------------------------------------*/
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  }

  /*------------------------------------------
  --------------------------------------------
  Created constructor
  --------------------------------------------
  --------------------------------------------*/
  constructor(private httpClient: HttpClient) { }

  /**
   * Write code on Method
   *
   * @return response()
   */
  getAll(): Observable<any> {

    return this.httpClient.get(this.apiURL + '/peticiones/')

    .pipe(
      catchError(this.errorHandler)
    )
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  create(post:Peticion): Observable<any> {

    return this.httpClient.post(this.apiURL + '/peticiones/', JSON.stringify(post), this.httpOptions)

    .pipe(
      catchError(this.errorHandler)
    )
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  find(id:number): Observable<any> {

    return this.httpClient.get(this.apiURL + '/peticiones/' + id)

    .pipe(
      catchError(this.errorHandler)
    )
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  update(id:number, post:Peticion): Observable<any> {

    return this.httpClient.put(this.apiURL + '/peticiones/' + id, JSON.stringify(post), this.httpOptions)

    .pipe(
      catchError(this.errorHandler)
    )
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  delete(id:number){
    return this.httpClient.delete(this.apiURL + '/peticiones/' + id, this.httpOptions)

    .pipe(
      catchError(this.errorHandler)
    )
  }

  /**
   * Write code on Method
   *
   * @return response()
   */
  errorHandler(error:any) {
    let errorMessage = '';
    if(error.error instanceof ErrorEvent) {
      errorMessage = error.error.message;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(errorMessage);
 }
}
