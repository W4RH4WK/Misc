'use strict';

class Scheduler {
  constructor() {
    this.queue = [];
  }

  addProcess(process) {
    throw new Error('Abstract Method');
  }

  takeProcess() {
    throw new Error('Abstract Method');
  }
}

const schedulers = {
  FCFS: new class extends Scheduler {
    addProcess(process) {
      this.queue.unshift(process);
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.pop();
    }
  },

  SJF: new class extends Scheduler {
    addProcess(process) {
      this.queue.unshift(process);
      this.queue.sort(function (x, y) { return x.duration - y.duration });
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.shift();
    }
  },

  SRTF: new class extends Scheduler {
    addProcess(process) {
      this.queue.unshift(process);
      this.queue.sort(function (x, y) { return x.timeleft - y.timeleft });
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.shift();
    }
  },

  HPF: new class extends Scheduler {
    addProcess(process) {
      this.queue.unshift(process);
      this.queue.sort(function (x, y) { return x.priority - y.priority; });
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.shift();
    }
  },

  RR: new class extends Scheduler {
    addProcess(process) {
      this.queue.unshift(process);
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.pop();
    }
  },

  Lottery: new class extends Scheduler {
    addProcess(process) {
      if ('compensationFactor' in process) {
        process.compensationFactor = 1 / process.quantum;
      } else {
        process.compensationFactor = 1;
      }
      this.queue.unshift(process);
      this.queue.sort(function (x, y) {
        let x_tickets = Math.floor(x.tickets * x.compensationFactor);
        let y_tickets = Math.floor(y.tickets * y.compensationFactor);
        return x_tickets - y_tickets;
      });
    }

    takeProcess() {
      if (this.queue.length <= 0) {
        return false;
      }
      return this.queue.pop();
    }
  }
};
