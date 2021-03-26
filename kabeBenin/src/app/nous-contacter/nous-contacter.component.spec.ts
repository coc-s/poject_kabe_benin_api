import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NousContacterComponent } from './nous-contacter.component';

describe('NousContacterComponent', () => {
  let component: NousContacterComponent;
  let fixture: ComponentFixture<NousContacterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NousContacterComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(NousContacterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
