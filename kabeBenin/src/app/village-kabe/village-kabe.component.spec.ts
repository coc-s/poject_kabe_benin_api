import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VillageKabeComponent } from './village-kabe.component';

describe('VillageKabeComponent', () => {
  let component: VillageKabeComponent;
  let fixture: ComponentFixture<VillageKabeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VillageKabeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VillageKabeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
