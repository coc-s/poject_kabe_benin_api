import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuAccueilComponent } from './menu-accueil.component';

describe('MenuAccueilComponent', () => {
  let component: MenuAccueilComponent;
  let fixture: ComponentFixture<MenuAccueilComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MenuAccueilComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MenuAccueilComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
