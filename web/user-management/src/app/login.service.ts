import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  user: any;

  constructor(
    public router: Router
  ) { }

  login(username: string, password: string): Observable<any> {
    // Everything will change here..
    return of({
      success: true
    }).pipe(
      tap(res => {
        this.user = username;
        localStorage.setItem('loggedIn', username);
      })
    );
  }

  loggedIn(): boolean {
    const user = localStorage.getItem('loggedIn');
    this.user = user;
    return !!this.user;
  }

  logout(): void {
    localStorage.removeItem('loggedIn');
    this.user = null;
    this.router.navigateByUrl('/login');
  }
}
